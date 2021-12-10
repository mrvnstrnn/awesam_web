<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RTBDeclaration extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql2';
    public $timestamps = false;
    protected $table = 'rtb_declaration';

    protected $fillable = ['sam_id', 'rtb_declaration_date', 'rtb_declaration', 'status', 'date_created', 'date_updated', 'user_id', 'approver_id', 'remarks'];
}
