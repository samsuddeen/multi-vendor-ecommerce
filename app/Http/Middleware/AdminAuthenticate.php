<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // one
        if(!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }
        //two
        if(!Auth::guard('admin')->user()->status)
            {
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')->with('error','Account Deactivated');
            }
        return $next($request);
    }
}
