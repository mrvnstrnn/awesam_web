<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    // protected $connection = 'mysql2';
    protected $table = 'request';
    public $timestamps = false;

    protected $fillable = ['agent_id', 'supervisor_id', 'request_type', 'start_date_requested', 'end_date_requested', 'reason', 'comment', 'leave_status'];
}
