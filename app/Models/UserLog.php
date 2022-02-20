<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    // protected $connection = 'mysql2';
    protected $table = 'user_logs';
    protected $fillable = ['user_id','via'];
}
