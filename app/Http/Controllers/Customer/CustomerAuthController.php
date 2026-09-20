<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class CustomerAuthController extends Controller
{
    
public function showRegister()
{
    return view('frontend.auth.register');
}


public function register(Request $request)
{
    // dd($request->all());
$request->validate([
'name' => ['required', 'string'],
'email' => ['required'],
'phone' =>['required'],
'password' => ['required', 'confirmed']
]);

$customer = Customer::create([

'name' => $request->name,
'email' => $request->email,
'phone' => $request->phone,
'password' => Hash::make($request->password),
'status' => true,

]);

$otp = $customer->generateOtp();
Mail::to($customer->email)->send(new OtpMail($customer->name, $otp));


session(['verify_customer_id' =>$customer->id]);

 return redirect()
   ->back()
    ->with('success', 'Registration successful!')
    ->with('openOtpModal', true);

}


}
