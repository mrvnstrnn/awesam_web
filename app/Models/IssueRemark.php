<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueRemark extends Model
{
    use HasFactory;

    // protected $connection = 'mysql2';
    protected $table = 'site_issue_remarks';
    public $timestamps = false;
    
    protected $fillable = ['site_issue_id', 'remarks', 'status', 'date_engage'];


}
