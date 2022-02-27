<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Site;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('site-tracking.{user_id}', function ($site, $user_id) {
//     return $user->id === Site::findOrNew($orderId)->user_id;
// });

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});