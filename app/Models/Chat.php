<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    // protected $connection = 'mysql2';
    public $timestamps = false;
    protected $table = 'chat';
    protected $fillable = ['user_id', 'sam_id', 'comment', 'created_at'];
}
