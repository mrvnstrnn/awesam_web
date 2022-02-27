<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersArea extends Model
{
    use HasFactory;

    // protected $connection = 'mysql2';
    public $timestamps = false;
    protected $table = 'users_areas';

    protected $fillable = ['user_id', 'region', 'province', 'lgu'];
}
