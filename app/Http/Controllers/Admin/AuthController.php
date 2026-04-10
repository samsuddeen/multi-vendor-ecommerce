<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use League\Config\Exception\ValidationException;

class AuthController extends Controller
{

//     public function showLogin()
//     {
//         if(Auth::guard('admin')->check()) {

//         return redirect()->route('admin.dashboard');
//         }
//         return view('admin.auth.login');
//     }

//     public function login(Request $request)
//     {
//         $request->validate([
//             'email' => 'required',
//             'password' => 'required'

//         ]);

//         $admin = Admin::where('email', $request->email)->first();

//         if (!$admin) {
//             return redirect()->back()->with('error', ' credential Doesnot match');
//         }

//         if ($admin->isLocked()) {
//             return redirect()->back()->with('error', 'your account is locked please wait');
//         }

//         if (!$admin->status) {
//             return redirect()->back()->with('error', 'your account is inactive.');
//         }

//         if (!Hash::check($request->password, $admin->password)) {
//             $admin->recordFailedLogin();
//             $remaining = max(0, 5 - $admin->fresh()->failed_login_attempts);

//            if ($remaining > 0)  {
//                 return redirect()->back()->with('error', 'your password is incorrect.');
//             } else {
//                 return redirect()->back()->with('error', 'your account has been locked');
//             }
//         }

//         Auth::guard('admin')->login($admin, $request->boolean('remember'));
//         $admin->recordSuccessfulLogin($request->ip());
//         $request->session()->regenerate();
//         return redirect()->route('admin.dashboard')->with('success','welcome to the dashboard');

//     }
}
