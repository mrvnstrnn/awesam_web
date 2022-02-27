<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;
    // protected $connection = 'mysql2';
    public $timestamps = false;
    protected $table = 'site_issue';
    protected $fillable = ['issue_type_id', 'sam_id', 'what_activity_id', 'issue_details', 'issue_status', 'sdate_resolve', 'user_id', 'start_date', 'approvers'];
}
