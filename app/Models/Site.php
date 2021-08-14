<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Broadcasting\Channel;

class Site extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'site';
    public $timestamps = false;

    public function broadcastOn($event)
    {
        return [new Channel('site.tracking')];
    }
    
    public function broadcastAs()
    {
        return 'SiteTracking';
    }
}
