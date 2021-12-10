<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $primaryKey = 'vendor_id';
    protected $table = 'vendor';

    protected $fillable = [
        // 'vendor_id',
        'vendor_firstname',
        'vendor_lastname',
        'vendor_admin_email',
        'vendor_sec_reg_name',
        'vendor_acronym',
        'vendor_office_address',
        'vendor_status',
        'vendor_profile_id'
    ];
}
