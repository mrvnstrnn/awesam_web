<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name, $vendor_admin_email, $vendor_sec_reg_name, $vendor_acronym, $password, $url;

    public function __construct($name, $vendor_admin_email, $vendor_sec_reg_name, $vendor_acronym)
    {
        $this->name = $name;
        $this->vendor_admin_email = $vendor_admin_email;
        $this->vendor_sec_reg_name = $vendor_sec_reg_name;
        $this->vendor_acronym = $vendor_acronym;
        $this->password = 12345678;
        // $this->password = $password;
        $this->url = route('login');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.vendorinvitation')
                        ->subject('Vendor Invitation');
    }

}
