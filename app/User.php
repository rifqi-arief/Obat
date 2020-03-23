<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'email', 
        'password',
        'telepon', 
        'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
