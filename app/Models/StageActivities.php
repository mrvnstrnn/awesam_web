<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StageActivities extends Model
{    
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'mysql2';
    protected $table = 'stage_activities';
    protected $fillable = ['program_id', 'category', 'activity_id', 'profile_id', 'activity_name', 'activity_sequence', 'next_activity', 'return_activity'];
}
