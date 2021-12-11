<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubActivityValue extends Model
{
    use HasFactory;

    public $timestamps = false;
    // protected $connection = 'mysql2';
    protected $table = 'sub_activity_value';
    protected $fillable = ['sam_id', 'sub_activity_id', 'sub_activity_id', 'value', 'status', 'user_id', 'type', 'date_approved'];
}
