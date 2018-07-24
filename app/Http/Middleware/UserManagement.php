<?php

namespace App\Http\Middleware;

use Closure;

class UserManagement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (! $request->session()->has('logged_in') || ! $request->session()->get('logged_in')) {
            return redirect('/users/login');
        }
        return $next($request);
    }
}
