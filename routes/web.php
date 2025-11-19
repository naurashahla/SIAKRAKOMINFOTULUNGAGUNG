<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

// Public routes - redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Optional: Keep welcome page accessible at /welcome
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/password/reset', function() {
    return view('auth.passwords.email');
})->name('password.request');

Route::post('/password/email', function() {
    request()->validate(['email' => 'required|email']);
    
    $status = Password::sendResetLink(
        request()->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->name('password.email');

Route::get('/password/reset/{token}', function($token) {
    return view('auth.passwords.reset', ['token' => $token]);
})->name('password.reset');

use App\Http\Controllers\UserController;
Route::post('/password/reset', function() {
    request()->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        request()->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {

// NOTE: user management routes were misplaced here and have been moved to the admin middleware group below.
            $user->forceFill([
                'password' => Hash::make($password)
            ]);

            $user->save();
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->name('password.update');

// Protected routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    
    // Event management routes - Read access for all authenticated users
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    
    // Events data API for calendar
    Route::get('/events-data', [EventController::class, 'getEventsData'])->name('events.data');
    
    // Event management routes - previously restricted to admin, now accessible to authenticated users.
    // If you want to re-introduce role-based checks, add Gate/POLICY checks inside controllers.
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // Word export routes
    Route::get('/events/daily-export/word/{date}', [EventController::class, 'exportDailyEventsToWord'])->name('events.daily-export.word');

    // User management (now accessible to authenticated users)
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    // CSV export for users (admins/super_admins)
    Route::get('/users-export', [\App\Http\Controllers\UserController::class, 'export'])->name('users.export');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    // Role change endpoint (used by action dropdown and admin edit form)
    Route::post('/users/{user}/role', [\App\Http\Controllers\UserController::class, 'changeRole'])->name('users.changeRole');
    Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    // Note: role change and admin listing routes removed as admin concept has been removed.
    // Pegawai / penerima management
    Route::get('/pegawai', [\App\Http\Controllers\PegawaiController::class, 'index'])->name('pegawai.index');
    Route::get('/pegawai/create', [\App\Http\Controllers\PegawaiController::class, 'create'])->name('pegawai.create');
    Route::post('/pegawai', [\App\Http\Controllers\PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{pegawai}/edit', [\App\Http\Controllers\PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{pegawai}', [\App\Http\Controllers\PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{pegawai}', [\App\Http\Controllers\PegawaiController::class, 'destroy'])->name('pegawai.destroy');
    Route::get('/pegawai-export', [\App\Http\Controllers\PegawaiController::class, 'exportCsv'])->name('pegawai.export');

    // Options management (bidang / jabatan) - used by admin UI to manage select lists
    Route::post('/options', [\App\Http\Controllers\OptionController::class, 'store'])->name('options.store');
    Route::delete('/options/{option}', [\App\Http\Controllers\OptionController::class, 'destroy'])->name('options.destroy');
    Route::get('/options-json', [\App\Http\Controllers\OptionController::class, 'list'])->name('options.list');
    
    // Routes with parameters must come after specific routes
    // Completion form routes (before show to avoid collisions)
    Route::get('/events/{event}/complete', [EventController::class, 'completeForm'])->name('events.complete.form');
    Route::post('/events/{event}/complete', [EventController::class, 'submitCompletion'])->name('events.complete.submit');

    // Edit / Update / Delete completions (notulen + bukti dukung)
    Route::get('/events/{event}/completions/{completion}/edit', [EventController::class, 'editCompletion'])->name('events.completions.edit');
    Route::put('/events/{event}/completions/{completion}', [EventController::class, 'updateCompletion'])->name('events.completions.update');
    Route::delete('/events/{event}/completions/{completion}', [EventController::class, 'destroyCompletion'])->name('events.completions.destroy');
    // Delete a single file attached to a completion (AJAX)
    Route::post('/events/{event}/completions/{completion}/files/delete', [EventController::class, 'deleteCompletionFile'])->name('events.completions.file.delete');
    // Preview and download single completion file via controller (avoids relying on public/storage symlink)
    Route::get('/events/{event}/completions/{completion}/files/preview', [EventController::class, 'previewCompletionFile'])->name('events.completions.file.preview');
    Route::get('/events/{event}/completions/{completion}/files/download', [EventController::class, 'downloadCompletionFile'])->name('events.completions.file.download');

    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/download-document', [EventController::class, 'downloadDocument'])->name('events.download-document');
    // Preview (stream) document through controller to ensure correct headers/encoding
    Route::get('/events/{event}/preview-document', [EventController::class, 'previewDocument'])->name('events.preview-document');
        // Attendance and transfer actions
        Route::post('/events/{event}/attend', [EventController::class, 'attend'])->name('events.attend');
        Route::post('/events/{event}/transfer', [EventController::class, 'transferDocument'])->name('events.transfer');
    
    // Debug route to test JSON response
    Route::get('/test-events-json', function() {
        $events = \App\Models\Event::select('id', 'title', 'startDate')->take(3)->get();
        return response()->json([
            'success' => true,
            'count' => $events->count(),
            'events' => $events,
            'message' => 'JSON implementation is working'
        ]);
    });
    
    // Test admin middleware specifically
    Route::get('/test-admin-middleware', function() {
        return 'Admin middleware works! You can access admin routes.';
    })->middleware(['auth', 'admin']);
    
    // Test admin access (detailed debug)
// Debug route to check if EventController is accessible
Route::get('/test-event-controller', function () {
    try {
        $controller = new \App\Http\Controllers\EventController();
        return 'EventController can be instantiated successfully. User: ' . (Auth::check() ? Auth::user()->email : 'Not logged in');
    } catch (\Exception $e) {
        return 'Error instantiating EventController: ' . $e->getMessage();
    }
});

Route::get('/admin-debug', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return response()->json([
            'authenticated' => true,
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role ?? 'NO_ROLE_COLUMN',
            'has_role_attribute' => isset($user->role),
            'class' => get_class($user),
            'message' => 'User data retrieved successfully'
        ]);
    }
    return response()->json(['authenticated' => false]);
});

// Simple route test without middleware
Route::get('/simple-test', function () {
    return 'Simple route working - no middleware';
});

// Admin middleware test route  
Route::middleware(['admin'])->group(function () {
    Route::get('/test-admin-middleware', function () {
        return 'Admin middleware test successful! User: ' . Auth::user()->email . ' Role: ' . Auth::user()->role;
    });
});    // Test admin access (simple)
    Route::get('/admin-test', function() {
        $user = Auth::user();
        return 'User: ' . $user->email . ', Role: ' . ($user->role ?? 'NO_ROLE') . ', Is Admin: ' . ($user->role === 'admin' ? 'YES' : 'NO');
    })->middleware('auth');
    
    // Telegram functionality removed: test routes deleted
});
