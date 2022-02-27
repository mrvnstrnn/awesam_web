<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LOIMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $file, $file_array;

    public function __construct($file, $file_array)
    {
        $this->file = $file;
        $this->file_array = $file_array;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        
        $email = $this->markdown('emails.loi')
                    ->subject('LOI Contracts');

        // for ($i=0; $i < count($this->file_array); $i++) { 
        //     $email->attachFromStorage($this->file_array[$i]);
        // }

        return $email;
    }
}
