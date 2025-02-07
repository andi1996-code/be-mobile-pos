<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    public function handle($request, \Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        if (Auth::check() && Auth::user()->roles != 'admin') {
            Auth::logout();
            return redirect('/login')->with('error', 'Anda tidak memiliki akses sebagai admin.');
        }

        return $next($request);
    }
}
