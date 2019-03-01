<?php

namespace App\Http\Middleware;

use Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        // This authentication will check token.
        // when they are not authenticated by token but still login with session
        // Logout from session too
        Auth::logout();

        // Redirect to login page
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
