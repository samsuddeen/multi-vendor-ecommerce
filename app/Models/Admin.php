<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use function Illuminate\Support\minutes;

#[Fillable(['name', 'email', 'password','avatar','phone','status','last_login_ip', 'last_login_at','failed_login_attempts','locked_until'])]
#[Hidden(['password', 'remember_token','two_factor_recovery_codes','two_factor_secret'])]
class Admin extends Authenticatable
{
    use HasFactory, Notifiable;


protected $casts = [
    'status' => 'boolean',
    'email_verified_at' => 'datetime',
    'last_login_at' => 'datetime',
    'locked_until' =>'datetime',
    'password' => 'hashed',
    'failed_login_attempts' => 'integer',

];

public function isLocked()
{
return $this->locked_until && $this->locked_until->isFuture();
}

//remaining
public function lockRemainingMinutes()
{
    return $this->isLocked() ? (int) now()->diffInMinutes($this->locked_until) : 0;

}


public function recordFailedLogin()
{
   // variable  :-
    $newCount = $this->fresh()->failed_login_attempts + 1;
    $this->update([
        'failed_login_attempts' => $newCount,
        // 'locked_until' =>$newCount >=5 ? now()->addMinutes(30) : $this->locked_until,
        // 5 >=5
        'locked_until' => $newCount >= 5 ? Carbon::now()->addMinutes(30) : $this->locked_until,
    ]);
}

public function recordSuccessfulLogin(string $ip)
{
    $this->update([
        'failed_login_attempts' => 0,
        'locked_until' => null,
        'last_login_ip' =>$ip,
        'last_login_at' => now(),


    ]);
}





}
