<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StageActivitiesProfile extends Model
{
    use HasFactory;
    public $timestamps = false;
    // protected $connection = 'mysql2';
    protected $table = 'stage_activities_profiles';
    protected $fillable = ['stage_activity_id', 'activity_component', 'activity_source', 'profile_id'];
}
