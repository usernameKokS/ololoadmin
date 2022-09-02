<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['email', 'password'];
    protected $hidden = ['password'];

    protected $table = 'admins';
    public $timestamps = false;
}
