<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')->with('error', 'Unauthorized !!');
        }

        $customer = Auth::guard('customer')->user();
        if ($customer->isBanned()) {
            Auth::guard('customer')->logout();
            return redirect()->route('customer.login')->with('error', 'Please Activate Your Account');
        }

        return $next($request);
    }
}
