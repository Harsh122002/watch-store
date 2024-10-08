<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionExpired
{
    public function handle($request, Closure $next)
    {
        // Define session expiration time (e.g., 60 minutes)
        $sessionLifetime = 60 * 60; // 1 hour in seconds

        // Check if the user is authenticated
        if (Auth::check()) {
            // Retrieve the last activity timestamp from the session
            $lastActivity = $request->session()->get('user_session');

            if ($lastActivity) {
                // Check if the session has expired
                if (time() - $lastActivity > $sessionLifetime) {
                    // Log the user out
                    Auth::logout();

                    // Clear the session
                    $request->session()->flush();

                    // Redirect to the login page with an error message
                    return redirect('/login')->with('error', 'Your session has expired, please login again.');
                }
            }

            // Update the session with the current timestamp
            $request->session()->put('user_session', time());
        }

        return $next($request);
    }
}
