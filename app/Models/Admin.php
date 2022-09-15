<?php

namespace App\Models;

use App\Traits\LoginTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;

class Admin extends User
{
    use HasFactory, LoginTrait;

    protected $guarded = [];
    protected $hidden = ['password'];
    protected static $guardName = 'admin';
}
