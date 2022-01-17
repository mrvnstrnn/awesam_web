<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $url, $name, $company;
    public function __construct($url, $name, $company)
    {
        $this->url = $url;
        $this->name = $name;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invitation')
                    ->from('awesamtool@globe.com.ph', 'aweSAM Tool')
                    ->cc('awesamtool@globe.com.ph')
                    ->subject('aweSAM Tool Registration Link');
    }
}
