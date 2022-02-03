<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
// use Pusher\Pusher;
use App\Models\User;

use Notification;
use App\Notifications\SiteMoved;

class NotificationController extends Controller
{

    public function notification()
    {
        $userSchema = User::first();
  
        $notifData = [
            'title' => 'New Notification',	
            'body' => 'You received a notification.',
            'thanks' => 'Thank you',
            'goUrl' => url('/'),
        ];
  
        Notification::send($userSchema, new SiteMoved($notifData));
 

        dd('Task completed!');		
    }

}