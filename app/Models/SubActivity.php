<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubActivity extends Model
{
    use HasFactory;

    public $timestamps = false;
    // protected $connection = 'mysql2';
    protected $table = 'sub_activity';
}
