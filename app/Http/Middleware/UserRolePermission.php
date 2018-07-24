<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class UserRolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('logged_in') && $request->session()->get('logged_in')) {
            $userId = $request->session()->get('user')['user_id'];
            if (! \App\Permission::isAllowed($request->path(), $userId)) {
//                Session::put('errors', ['Permission denied.']);
                if ($request->ajax()) {
                    return \view('message.error');
                }

                return redirect()->back();
            }
        }
        return $next($request);
    }
}
