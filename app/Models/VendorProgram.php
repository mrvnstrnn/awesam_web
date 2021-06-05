<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorProgram extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'vendor_programs';

    protected $fillable = [
        'vendors_id',
        'programs',
    ];
}
