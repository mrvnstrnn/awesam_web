<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddVendorProfile extends Model
{
    use HasFactory;
    public $timestamps = false;
    // protected $connection = 'mysql2';
    protected $table = 'add_vendor_profile';
    protected $fillable = ['vendor_id', 'vendor_profile'];
}
