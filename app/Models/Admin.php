<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use Notifiable,SoftDeletes;
    protected $guard = 'admin';
    protected $fillable=['email','password','remember_token'];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
