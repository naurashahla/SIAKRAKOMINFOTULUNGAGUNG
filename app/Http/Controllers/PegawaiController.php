<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PegawaiController extends Controller
{
    /**
     * Display a listing of pegawai (recipients).
     */
    public function index()
    {
        $q = request('q');
        $bidang = request('bidang');

        $query = Pegawai::query();
        $nameCol = Pegawai::nameColumn();

        if ($q) {
            $query->where(function($sub) use ($nameCol){
                $sub->where($nameCol, 'like', '%' . request('q') . '%')
                    ->orWhere('email', 'like', '%' . request('q') . '%');
            });
        }

        if ($bidang) {
            $query->where('bidang', $bidang);
        }

        $pegawai = $query->orderBy($nameCol)->paginate(20)->withQueryString();

        // bidang options for filter
        $bidangOptions = Pegawai::getBidangOptions();

        return view('pegawai.index', compact('pegawai', 'bidangOptions'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('pegawai.create');
    }

    /**
     * Store new pegawai
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => [
                'nullable','email',
                Rule::unique((new Pegawai)->getTable(), 'email')
            ],
            'bidang' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        Pegawai::create($data);

        return redirect()->route('pegawai.index')->with('success', 'Penerima berhasil ditambahkan.');
    }

    /**
     * Show edit form
     */
    public function edit(Pegawai $pegawai)
    {
        // provide bidang/jabatan options to populate selects and manage them
        $bidangOptions = Pegawai::getBidangOptions();
        $jabatanOptions = Pegawai::getJabatanOptions();
        return view('pegawai.edit', compact('pegawai', 'bidangOptions', 'jabatanOptions'));
    }

    /**
     * Update pegawai
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => [
                'nullable','email',
                Rule::unique((new Pegawai)->getTable(), 'email')->ignore($pegawai->id)
            ],
            'bidang' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $pegawai->update($data);

        return redirect()->route('pegawai.index')->with('success', 'Penerima berhasil diperbarui.');
    }

    /**
     * Hapus pegawai
     */
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Penerima berhasil dihapus.');
    }

    /**
     * Export current filtered list to CSV
     */
    public function exportCsv()
    {
        $q = request('q');
        $bidang = request('bidang');

        $nameCol = Pegawai::nameColumn();
        $query = Pegawai::query();
        if ($q) {
            $query->where(function($sub) use ($nameCol){
                $sub->where($nameCol, 'like', '%' . request('q') . '%')
                    ->orWhere('email', 'like', '%' . request('q') . '%');
            });
        }
        if ($bidang) {
            $query->where('bidang', $bidang);
        }

        $filename = 'pegawai_export_' . date('Ymd_His') . '.csv';

        $response = new StreamedResponse(function() use ($query, $nameCol) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Nama', 'Email', 'Bidang', 'Jabatan']);

            $query->orderBy($nameCol)->chunk(100, function($rows) use ($handle, $nameCol) {
                foreach ($rows as $row) {
                    fputcsv($handle, [$row->id, $row->nama, $row->email, $row->bidang, $row->jabatan]);
                }
            });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
