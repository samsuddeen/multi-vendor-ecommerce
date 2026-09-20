<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VendorAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //! => not
       if(!Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.login');
        }
        //two
        if(!Auth::guard('vendor')->user()->isActive())
            {
                Auth::guard('vendor')->logout();
                return redirect()->route('vendor.login')->with('error','Account Deactivated');
            }
        return $next($request);
    }
    }

