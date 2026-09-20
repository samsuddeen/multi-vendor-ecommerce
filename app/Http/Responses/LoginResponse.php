<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create a new class instance.
     */
    public function toResponse($request)
    {
        if(Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if(Auth::guard('vendor')->check()) {
            return redirect()->route('vendor.dashboard');
        }
        return redirect('/');
        // if(Auth::guard('customer')->check()) {
        //     return redirect()->route('customer.dashboard');
        // }
        // if(Auth::guard('admin')->check()) {
        //     return redirect()->route('admin.dashboard');
        // }
    }

}
