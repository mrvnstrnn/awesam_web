<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Broadcasting\Channel;

class SiteStageTracking extends Model
{
    use HasFactory;
    public $timestamps = false;
    // protected $connection = 'mysql2';
    protected $table = 'site_stage_tracking';
    protected $fillable = ['sam_id', 'activity_id', 'activity_complete', 'user_id'];

    public function broadcastOn($event)
    {
        return [new Channel('site.tracking')];
    }
    
    public function broadcastAs()
    {
        return 'SiteTracking';
    }
}
