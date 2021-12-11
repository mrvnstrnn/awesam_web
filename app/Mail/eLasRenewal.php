<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class eLasRenewal extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $sam_id, $program_id, $site_category, $activity_id, $token, $reference_number, $filing_date;
    public function __construct( $sam_id, $program_id, $site_category, $activity_id, $token, $reference_number, $filing_date )
    {
        $this->sam_id = $sam_id;
        $this->program_id = $program_id;
        $this->site_category = $site_category;
        $this->activity_id = $activity_id;
        $this->token = $token;
        $this->reference_number = $reference_number;
        $this->filing_date = $filing_date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.elas-renewal')
                        ->subject('eLAS Request');
    }
}
