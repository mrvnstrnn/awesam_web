<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    // protected $connection = 'mysql2';
    protected $fillable = ['invitation_code', 'mode', 'company_id', 'firstname', 'lastname', 'email', 'use', 'token'];
}
