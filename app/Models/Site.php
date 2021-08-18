<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;

class Site extends Model
{
    use BroadcastsEvents, HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'site';
    public $timestamps = false;

    public function broadcastOn($event)
    {
        return [new PrivateChannel('site-tracking.'.\Auth::id())];
    }
    
    public function broadcastAs()
    {
        return 'SiteTracking';
    }
}
