<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToweCoFile extends Model
{
    use HasFactory;

    public $timestamps = false;
    // protected $connection = 'mysql2';
    protected $table = 'towerco_files';
    protected $fillable = ['serial_number', 'file_name', 'type', 'user_id', 'date_uploaded'];
}
