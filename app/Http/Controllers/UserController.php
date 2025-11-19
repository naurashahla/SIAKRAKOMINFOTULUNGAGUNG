<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index()
    {
        // Build unified list of users and pegawai (recipients) so they appear in one table.
        // We'll merge into a single collection and paginate it.
        $q = request('pegawai_q');
        $filterBidang = request('pegawai_bidang');

        $usersQuery = User::orderBy('name');
        $pegNameCol = Pegawai::nameColumn();
        $pegawaiQuery = Pegawai::orderBy($pegNameCol);

        if ($q) {
            $usersQuery->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            });
            $pegawaiQuery->where(function($sub) use ($q, $pegNameCol) {
                $sub->where($pegNameCol, 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($filterBidang) {
            $usersQuery->where('bidang', $filterBidang);
            $pegawaiQuery->where('bidang', $filterBidang);
        }

        $usersAll = $usersQuery->get();
        $pegawaiAll = $pegawaiQuery->get();

        // Normalize into a unified array structure and deduplicate.
        // Use email (lowercased) as primary dedupe key; prefer `users` entries when email matches.
        $map = [];

        foreach ($usersAll as $u) {
            $emailKey = $u->email ? strtolower($u->email) : null;
            $key = $emailKey ?: 'user:' . $u->id;
            $map[$key] = [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'type' => 'user',
                'role' => $u->role ?? null,
                'bidang' => $u->bidang ?? null,
                'jabatan' => $u->jabatan ?? null,
                'created_at' => $u->created_at,
            ];
        }

        foreach ($pegawaiAll as $p) {
            $emailKey = $p->email ? strtolower($p->email) : null;
            if ($emailKey && isset($map[$emailKey])) {
                // merge bidang/jabatan into existing user record if missing
                if (empty($map[$emailKey]['bidang']) && !empty($p->bidang)) {
                    $map[$emailKey]['bidang'] = $p->bidang;
                }
                if (empty($map[$emailKey]['jabatan']) && !empty($p->jabatan)) {
                    $map[$emailKey]['jabatan'] = $p->jabatan;
                }
                continue; // skip adding duplicate pegawai row
            }

            // No matching user by email; add pegawai as its own entry
            $key = $emailKey ?: 'pegawai:' . $p->id;
            $map[$key] = [
                'id' => $p->id,
                'name' => $p->nama,
                'email' => $p->email,
                'type' => 'pegawai',
                'role' => null,
                'bidang' => $p->bidang,
                'jabatan' => $p->jabatan,
                'created_at' => $p->created_at,
            ];
        }

        $combined = collect(array_values($map))->sortBy('name')->values();

        // Paginate the combined collection
        $perPage = 20;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $itemsForCurrentPage = $combined->slice($offset, $perPage)->values();

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsForCurrentPage,
            $combined->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $bidangOptions = Pegawai::getBidangOptions();

        return view('users.index', ['people' => $paginator, 'bidangOptions' => $bidangOptions]);
    }

    public function create()
    {
        // Provide bidang and jabatan options so the create form is synchronized with database values
        $bidangOptions = \App\Models\Pegawai::getBidangOptions();
        $jabatanOptions = \App\Models\Pegawai::getJabatanOptions();
        return view('users.create', compact('bidangOptions', 'jabatanOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|in:admin,user,super_admin',
            'bidang' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        // Determine role based on current user's permission
        $role = 'user'; // default role
        
        if (isset($data['role']) && !empty($data['role'])) {
            $requestedRole = $data['role'];
            $currentUserRole = Auth::user()->role ?? 'user';
            // Normalize role (remove extra spaces)
            $currentUserRole = trim($currentUserRole);
            
            // Debug: Log current values
            Log::info('Role assignment debug:', [
                'requested_role' => $requestedRole,
                'current_user_role' => $currentUserRole,
                'current_user_id' => Auth::id(),
                'current_user_name' => Auth::user()->name ?? 'unknown',
            ]);
            
            // Super Admin can assign any role
            // Check for 'super_admin' or 'super admin' (both with underscore and space)
            $isCurrentUserSuperAdmin = (trim($currentUserRole) === 'super_admin' || 
                                       trim(str_replace('_', ' ', $currentUserRole)) === 'super admin');
            
            if ($isCurrentUserSuperAdmin) {
                $role = $requestedRole;
                Log::info('Role assigned as super_admin requested: ' . $requestedRole);
            }
            // Admin can assign user or admin (but not super_admin)
            elseif (trim($currentUserRole) === 'admin' || trim(str_replace('_', ' ', $currentUserRole)) === 'admin') {
                if ($requestedRole !== 'super_admin') {
                    $role = $requestedRole;
                }
                Log::info('Role assigned as admin: ' . $role);
            }
            // Regular users can only assign user role
            else {
                $role = 'user';
                Log::info('Role defaulted to user (current role: ' . $currentUserRole . ')');
            }
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
            'bidang' => $data['bidang'] ?? null,
            'jabatan' => $data['jabatan'] ?? null,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Change a user's role (admin only)
     */
    public function changeRole(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|in:admin,user,super_admin',
        ]);

        // Prevent user from changing their own role
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        // Enforce permission rules:
        // - Only super_admin can assign super_admin
        // - Admin or super_admin can assign admin
        $newRole = $data['role'];
        if ($newRole === 'super_admin') {
            if (!(Auth::user() && Auth::user()->role === 'super_admin')) {
                return redirect()->back()->with('error', 'Hanya Super Admin yang dapat menetapkan role Super Admin.');
            }
        } elseif ($newRole === 'admin') {
            if (!(Auth::user() && in_array(Auth::user()->role, ['admin', 'super_admin']))) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menetapkan role Admin.');
            }
        }

        $user->role = $newRole;
        $user->save();

        return redirect()->back()->with('success', 'Role pengguna berhasil diperbarui.');
    }

    /**
     * Tampilkan halaman manajemen admin (role = admin)
     */
    public function admins()
    {
        $admins = User::where('role', 'admin')->orderBy('name')->paginate(20);
        return view('admins.index', compact('admins'));
    }

    /**
     * Tampilkan form edit untuk user
     */
    public function edit(User $user)
    {
        $bidangOptions = \App\Models\Pegawai::getBidangOptions();
        $jabatanOptions = \App\Models\Pegawai::getJabatanOptions();
        return view('users.edit', compact('user', 'bidangOptions', 'jabatanOptions'));
    }

    /**
     * Perbarui data user
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'nullable|in:admin,user,super_admin',
            'bidang' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];


        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        // Prevent changing own role via this update form
        if (isset($data['role']) && Auth::id() === $user->id) {
            unset($data['role']);
        }

        // Enforce assignment rules similar to store/changeRole
        if (isset($data['role'])) {
            $requested = $data['role'];
            if ($requested === 'super_admin') {
                if (Auth::user() && Auth::user()->role === 'super_admin') {
                    $user->role = 'super_admin';
                }
            } elseif ($requested === 'admin') {
                if (Auth::user() && in_array(Auth::user()->role, ['admin', 'super_admin'])) {
                    $user->role = 'admin';
                }
            } else {
                $user->role = 'user';
            }
        }

        // Persist bidang and jabatan if provided
        if (array_key_exists('bidang', $data)) {
            $user->bidang = $data['bidang'];
        }
        if (array_key_exists('jabatan', $data)) {
            $user->jabatan = $data['jabatan'];
        }

        $user->save();

        // If the edit form provided a `return_to` relative path, redirect back there (preserve pagination/filter state).
        $returnTo = $request->input('return_to');
        if ($returnTo && is_string($returnTo) && str_starts_with($returnTo, '/')) {
            return redirect($returnTo)->with('success', 'User berhasil diperbarui.');
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        // Prevent user from deleting themselves
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }

    /**
     * Export users to CSV (streamed download).
     * Respects the same search and bidang filters used in the index view.
     * Accessible to admin and super_admin roles only.
     */
    public function export(Request $request)
    {
        // Basic authorization: only allow admin or super_admin
        if (!(Auth::check() && in_array(Auth::user()->role, ['admin', 'super_admin']))) {
            abort(403, 'Unauthorized');
        }

        $q = $request->get('pegawai_q');
        $filterBidang = $request->get('pegawai_bidang');

        $usersQuery = User::orderBy('name');

        if ($q) {
            $usersQuery->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($filterBidang) {
            $usersQuery->where('bidang', $filterBidang);
        }

        $users = $usersQuery->get(['name', 'email', 'role', 'bidang', 'jabatan']);

        $filename = 'users_export_' . now()->format('Ymd_His') . '.csv';

        $callback = function () use ($users) {
            $out = fopen('php://output', 'w');
            // Header row
            fputcsv($out, ['name', 'email', 'role', 'bidang', 'jabatan']);

            foreach ($users as $u) {
                fputcsv($out, [
                    $u->name,
                    $u->email,
                    $u->role,
                    $u->bidang,
                    $u->jabatan,
                ]);
            }

            fclose($out);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
