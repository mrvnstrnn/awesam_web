<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
// use Pusher\Pusher;
// use App\Models\User;

// class SiteMoved extends Notification implements ShouldBroadcast, ShouldQueue
class SiteMoved extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    { 
        // return ['database', 'broadcast'];
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject($this->message['title'])
                    ->line($this->message['body'])
                    ->cc(['awesamtool@globe.com.ph', 'maesternon@absi.ph'])
                    ->action('Notification Action', url($this->message['goUrl']))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message
        ];
    }

    // public function toBroadcast($notifiable): BroadcastMessage
    // {

    //     $options = array(
	// 		'cluster' => 'ap1',
	// 		'encrypted' => true
	// 	);
    //     $pusher = new Pusher(
	// 		'10d00ec4fed05fe27b51',
	// 		'b6dbcf5d7b2470bfdd2d',
	// 		'1279007', 
	// 		$options
	// 	);

    //     $data['message'] = $this->message;
    //     $pusher->trigger('site-moved', 'App\\Notifications\\SiteMoved', $data);

    //     return new BroadcastMessage([
    //         'message' => $this->message
    //     ]);

    // }


}
