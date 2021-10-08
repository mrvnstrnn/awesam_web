<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Pusher\Pusher;


use App\Notifications\SiteMoved;

class NotificationController extends Controller
{
    public function notification()
    {
        $options = array(
			'cluster' => 'ap1',
			'encrypted' => true
		);
        $pusher = new Pusher(
			'69e6d00a89f4405eece3',
			'dbc91ec8ec9ca7fd8bd6',
			'1209997', 
			$options
		);

        $data['message'] = '{"recipient" : "1"}';
        $pusher->trigger('site-moved', 'App\\Notifications\\SiteMoved', $data);

    }


}