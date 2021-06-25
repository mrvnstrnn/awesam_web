<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SiteEndorsementNotification extends Notification implements ShouldQueue
// class SiteEndorsementNotification extends Notification 
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $sam_id, $url, $data_complete, $subject, $line, $action;
    public function __construct($sam_id, $activity_name, $data_complete, $site_name = null, $file_name = null, $reason = null)
    {
        $this->sam_id = $sam_id;
        
        $this->data_complete = $data_complete == "false" ? "rejected" : "approved";

        if ($activity_name == "endorse_site") {

            if ($data_complete == "false") {
                $this->line = $this->sam_id . " has been rejected.";
            } else {
                $this->line = $this->sam_id. " has been endorsed.";
            }
            
            $this->subject = $this->sam_id ." Site Endorsement";
            $this->action = "View Endorsement";
            $this->url = url('/endorsements');

        } else if ($activity_name == "site_assign") {
            
            $this->subject = $this->sam_id ." Site Assigned";
            $this->line = $site_name . " has been assigned to you.";
            $this->action = "View Site";
            $this->url = url('/assigned-sites');

        } else if ($activity_name == "lessor_approval") {
            
            if ($data_complete == "active") {
                $this->line = $site_name . " submitted and now pending.";
            } else if ($data_complete == "approved") {
                $this->line = $site_name. " has been approved.";
            } else {
                $this->line = $site_name. " has been rejected.";
            }

            $this->subject = $this->sam_id ." Lessor Approval";
            $this->action = "View Activities";
            $this->url = url('/activities');

        } else if ($activity_name == "document_approval") {

            if ($data_complete == "approved") {
                $this->line = "File: " . $file_name;
            } else {
                $this->line = "This file (" . $file_name . ") is been rejected because of " . $reason;
            }

            $this->subject = $this->sam_id . " Document " .ucfirst($data_complete);
            $this->action = "View Activities";
            $this->url = url('/activities');

        } else if ($activity_name == "rtb_docs_approval") {

            $this->line = $this->sam_id. " RTB documents has been approved";
            $this->subject = $this->sam_id ." RTB Document Approved";
            $this->action = "View Activities";
            $this->url = url('/activities');

        } else if ($activity_name == "rtb_declation") {

            $this->line = $this->sam_id. " RTB has been declared";
            $this->subject = $this->sam_id ." RTB Declaration";
            $this->action = "View Activities";
            $this->url = url('/activities');

        } else if ($activity_name == "rtb_declation_approval") {

            if ($data_complete == "false") {
                $this->line = $this->sam_id . " RTB Declaration has been rejected due to " . $reason;
            } else {
                $this->line = $this->sam_id . " RTB Declaration has been approved.";
            }
            
            $this->subject = $this->sam_id. " RTB Declaration Approval";
            $this->action = "View Activities";
            $this->url = url('/activities');

        } else if ($activity_name == "pac_approval") {

            if ($data_complete == "false") {
                $this->line = $this->sam_id . " has been rejected";
            } else {
                $this->line = $this->sam_id . " has been approved.";
            }
            
            $this->subject = $this->sam_id. " PAC Approval";
            $this->action = "View Activities";
            $this->url = url('/activities');

        } else if ($activity_name == "pac_director_approval") {

            if ($data_complete == "false") {
                $this->line = $this->sam_id . " has been rejected";
            } else {
                $this->line = $this->sam_id . " has been approved.";
            }
            
            $this->subject = $this->sam_id. " PAC Director Approval";
            $this->action = "View Activities";
            $this->url = url('/activities');

        } else if ($activity_name == "pac_vp_approval") {

            if ($data_complete == "false") {
                $this->line = $this->sam_id . " has been rejected";
            } else {
                $this->line = $this->sam_id . " has been approved.";
            }
            
            $this->subject = $this->sam_id. " PAC VP Approval";
            $this->action = "View Activities";
            $this->url = url('/activities');

        } else if ($activity_name == "fac_approval") {

            if ($data_complete == "false") {
                $this->line = $this->sam_id . " has been rejected";
            } else {
                $this->line = $this->sam_id . " has been approved.";
            }
            
            $this->subject = $this->sam_id. " FAC Approval";
            $this->action = "View Activities";
            $this->url = url('/activities');

        } else if ($activity_name == "fac_director_approval") {

            if ($data_complete == "false") {
                $this->line = $this->sam_id . " has been rejected";
            } else {
                $this->line = $this->sam_id . " has been approved.";
            }
            
            $this->subject = $this->sam_id. " FAC Director Approval";
            $this->action = "View Activities";
            $this->url = url('/activities');

        } else if ($activity_name == "fac_vp_approval") {

            if ($data_complete == "false") {
                $this->line = $this->sam_id . " has been rejected";
            } else {
                $this->line = $this->sam_id . " has been approved.";
            }
            
            $this->subject = $this->sam_id. " FAC VP Approval";
            $this->action = "View Activities";
            $this->url = url('/activities');

        }
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
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
                    ->subject($this->subject)
                    ->line($this->line)
                    ->action($this->action, $this->url)
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
        // return [
        //     //
        // ];

        return $this->sam_id;
    }
}
