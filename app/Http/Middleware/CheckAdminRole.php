<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            Log::warning('CheckAdminRole: User not authenticated');
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Enhanced debug logging
        Log::info('CheckAdminRole middleware', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role ?? 'NO_ROLE',
            'has_role_column' => isset($user->role),
            'requested_url' => $request->fullUrl(),
            'user_class' => get_class($user)
        ]);

        // Check role directly without method
        if ($user->role !== 'admin') {
            Log::warning('Access denied - not admin', [
                'user_role' => $user->role,
                'user_email' => $user->email,
                'requested_url' => $request->fullUrl()
            ]);
            abort(403, 'Access denied. Admin role required. Your role: ' . ($user->role ?? 'undefined'));
        }

        Log::info('Admin access granted', [
            'user_email' => $user->email,
            'requested_url' => $request->fullUrl()
        ]);

        return $next($request);
    }
}
