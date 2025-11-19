<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Event;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        // Generate a simple math captcha (two single-digit numbers)
        $a = rand(1, 9);
        $b = rand(1, 9);
        $captchaQuestion = "$a + $b";
        session(['captcha_sum' => $a + $b]);

        return view('auth.login', compact('captchaQuestion'));
    }

    /**
     * Handle proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha' => 'required|integer',
        ]);

    $credentials = $request->only('email', 'password');

        // Validate captcha answer stored in session
        $expected = session('captcha_sum');
        if (!is_null($expected) && (int) $request->input('captcha') !== (int) $expected) {
            // regenerate captcha for the next attempt
            $a = rand(1, 9);
            $b = rand(1, 9);
            session(['captcha_sum' => $a + $b]);

            return back()->withErrors([
                'captcha' => 'Jawaban captcha salah.'
            ])->onlyInput('email');
        }

    // 'Remember me' feature removed: always authenticate without persistent cookie
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Set different session timeout based on user role
            $user = Auth::user();
            if ($user->role === 'user') {
                // Set shorter timeout for regular users (15 minutes)
                config(['session.lifetime' => 15]);
                $request->session()->put('user_role_timeout', 15);
            } else {
                // Admin keeps default timeout (120 minutes)
                config(['session.lifetime' => 120]);
                $request->session()->put('user_role_timeout', 120);
            }
            
            // Clear captcha from session after successful login
            session()->forget('captcha_sum');

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle proses logout
     */
    public function logout(Request $request)
    {
        // Log out from the default guard
        Auth::logout();

        // Remove all session data
        try {
            $request->session()->flush();
        } catch (\Exception $e) {
            // ignore
        }

        // Invalidate the session and regenerate CSRF token and session id
        try {
            $request->session()->invalidate();
        } catch (\Exception $e) {
            // ignore
        }

        try {
            $request->session()->regenerateToken();
            $request->session()->regenerate();
        } catch (\Exception $e) {
            // ignore
        }

        // Forget remember-me cookie (best-effort; cookie name may vary by guard)
        try {
            if (function_exists('cookie')) {
                \Illuminate\Support\Facades\Cookie::queue(\Illuminate\Support\Facades\Cookie::forget(Auth::getRecallerName() ?? 'remember_web'));
            }
        } catch (\Exception $e) {
            // ignore
        }

        return redirect('/');
    }

    /**
     * Extend session for users
     */
    public function extendSession(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Only allow regular users to extend session
            if ($user->role === 'user') {
                // Reset last activity time
                $request->session()->put('last_activity', time());
                
                return response()->json([
                    'success' => true,
                    'message' => 'Sesi berhasil diperpanjang'
                ]);
            }
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Gagal memperpanjang sesi'
        ], 403);
    }

    /**
     * Tampilkan dashboard setelah login
     */
    public function dashboard()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        
        // Only eager-load recipients if the pivot table exists to avoid QueryExceptions
        $canLoadRecipients = Schema::hasTable('event_user_recipients');

        if ($canLoadRecipients) {
            $todaysEvents = Event::whereDate('startDate', $today)->with('recipients')->get();
            $tomorrowEvents = Event::whereDate('startDate', $tomorrow)->with('recipients')->get();
            $upcomingEvents = Event::where('startDate', '>', $today)
                                  ->with('recipients')
                                  ->orderBy('startDate', 'asc')
                                  ->limit(5)
                                  ->get();
        } else {
            // Fallback: load events without recipients and attach empty collections
            $todaysEvents = Event::whereDate('startDate', $today)->get();
            $tomorrowEvents = Event::whereDate('startDate', $tomorrow)->get();
            $upcomingEvents = Event::where('startDate', '>', $today)
                                  ->orderBy('startDate', 'asc')
                                  ->limit(5)
                                  ->get();

            foreach ([$todaysEvents, $tomorrowEvents, $upcomingEvents] as $collection) {
                foreach ($collection as $e) {
                    $e->setRelation('recipients', collect());
                }
            }
        }
        
        // Get stats
        $totalEvents = Event::count();
        $todaysCount = $todaysEvents->count();
        $tomorrowCount = $tomorrowEvents->count();
        $upcomingCount = Event::where('startDate', '>', $today)->count();
        
        // Count total recipients from the pivot table. The app now uses
        // `event_user_recipients` with `user_id` as the foreign key.
        if (Schema::hasTable('event_user_recipients')) {
            $totalRecipients = DB::table('event_user_recipients')->distinct('user_id')->count();
        } elseif (Schema::hasTable('event_recipients')) {
            // Fallback for older installations still using the old table
            $totalRecipients = DB::table('event_recipients')->distinct('pegawai_id')->count();
        } else {
            $totalRecipients = 0;
        }
        
        return view('dashboard', compact(
            'todaysEvents',
            'upcomingEvents', 
            'totalEvents',
            'todaysCount',
            'tomorrowCount',
            'upcomingCount',
            'totalRecipients'
        ));
    }
}