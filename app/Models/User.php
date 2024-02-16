<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    public function sendEmailVerificationNotification() 
    {
        $this->notify(new VerifyEmail());
    }

    public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
	}
	
    
    protected $hidden = [
		'password',
		'remember_token',
	];


    protected $casts = [
		'email_verified_at' => 'datetime',
		'password'          => 'hashed',
	];
}
