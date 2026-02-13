<?php
/**
 * Admin Web Authentication Middleware
 * 
 * Purpose: Ensures the current user is authenticated via the 'admin' guard.
 * Redirects unauthenticated users to the admin login page.
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
