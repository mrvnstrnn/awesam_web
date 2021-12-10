<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $fillable = ['user_id', 'mode', 'company_id', 'program_id', 'address_id'];
}
