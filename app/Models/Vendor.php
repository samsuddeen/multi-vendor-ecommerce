<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


#[Fillable(['name', 'email', 'password','avatar','phone','status', 'store_name','slug','last_login_ip', 'last_login_at','failed_login_attempts','locked_until'])]
#[Hidden(['password', 'remember_token','two_factor_recovery_codes','two_factor_secret'])]

class Vendor extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;
protected $table ='vendors';

protected $casts = [
    'email_verified_at' => 'datetime',
    'last_login_at' => 'datetime',
    'locked_until' =>'datetime',
    'password' => 'hashed',
    'failed_login_attempts' => 'integer',

];

// $this means ye current path
public function isPending()
{
    return $this->status == 'pending';
}
public function isSuspended()
{
    return $this->status == 'suspend';
}
public function isActive()
{
    return $this->status == 'active';
}

public function isLocked()
{
    return $this->locked_until && $this->locked_until->isFuture();
}


public function lockRemainingMinutes()
{
return $this->isLocked() ? (int) now()->diffInMinutes($this->locked_until) : 0;
}



public function recordFailedLogin()
{
    $newCount = $this->fresh()->failed_login_attempts + 1;
    $this->update([
        'failed_login_attempts' => $newCount,

        'locked_until' => $newCount >= 5 ? Carbon::now()->addMinutes(2) : $this->locked_until,
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
