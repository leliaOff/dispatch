<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UsersAuth extends Model
{
    protected $fillable = ['user_id', 'token'];
}
