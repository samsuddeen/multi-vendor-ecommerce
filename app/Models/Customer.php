<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['name', 'email', 'password','email_verified_at','phone_verified_at','phone','avatar','gender','date_of_birth','status','google_id','facebook_id','otp','address','otp_expired_at'])]
#[Hidden(['password', 'remember_token'])]
class Customer extends Authenticatable
{
    protected $table = "customers";
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'date_of_birth' => 'datetime',
        'otp_expired_at' => 'datetime',
        'status' => 'boolean',
        'password' => 'hashed'
    ];

    public function isActive()
    {
        return $this->status === true;

    }
    public function isBanned()
    {
        return $this->status === false;

    }

    public function generateOtp()
    {
        $otp = (string) rand(100000, 999999);
        $this->update([
            'otp' => $otp,
            'otp_expired_at' => Carbon::now()->addMinutes(10)
        ]);
        return $otp;

    }

    public function isValidOtp(string $otp)
    {
        return $this->otp === $otp &&
        $this->otp_expired_at &&
        $this->otp_expired_at->isFuture();
    }

    public function clearOtp()
    {
        $this->update([
            'otp' => null,
            'otp_expired_at' => null
        ]);
    }





}


