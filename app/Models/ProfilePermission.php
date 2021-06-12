<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePermission extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'profile_permissions';
    protected $fillable = ['profile_id', 'permission_id'];
}
