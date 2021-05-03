<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_fullname',
        'vendor_admin_email',
        'vendor_program_id',
        'vendor_sec_reg_name',
        'vendor_acronym',
        'vendor_office_address',
        'vendor_saq_status'
    ];

    public function getAllVendor()
    {
        return Vendor::join('vendor_programs', 'vendor_programs.vendor_program_id', 'vendors.vendor_program_id')->get();
    }
}
