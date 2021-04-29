<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GTInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $url, $name, $password, $company, $email;

    public function __construct($url, $name, $password, $company, $email)
    {
        $this->url = $url;
        $this->name = $name;
        $this->password = $password;
        $this->company = $company;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.gtinvitation')
                        ->subject('Login invitation link');
    }
}
