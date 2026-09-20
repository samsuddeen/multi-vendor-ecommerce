<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

// Route::get('/test-email', function(){
// Mail::raw('this a test mail from the attitude coder', function($message) {
//     $message->to('sahilaalam184@gmail.com')
//     ->subject('final test');
// });

//  return
// });

Route::get('/', function () {
    return view('frontend.layouts.app');
});
