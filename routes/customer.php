<?php

use App\Http\Controllers\Customer\CustomerAuthController;
use Illuminate\Support\Facades\Route;


Route::middleware('customer.guest')->group(function (){

Route::get('login', [CustomerAuthController::class, 'showLogin'])->name('login');
Route::post('login-post', [CustomerAuthController::class, 'login'])->name('login.post');

Route::get('register', [CustomerAuthController::class, 'showRegister'])->name('register');
Route::post('register-post', [CustomerAuthController::class, 'register'])->name('register.post');

// Route::get('verify-email', [CustomerAuthController::class, 'showVerifyOtp'])->name('verify.otp');
Route::post('verify-email-post', [CustomerAuthController::class, 'VerifyOtp'])->name('verify.otp.post');

Route::post('logout', [CustomerAuthController::class, 'logout'])->name('logout')->middleware('customer.auth');



Route::get('dashboard', [CustomerAuthController::class, 'dashboard'])->name('dashboard');


});
