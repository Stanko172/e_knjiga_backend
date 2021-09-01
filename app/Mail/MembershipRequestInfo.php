<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MembershipRequestInfo extends Mailable
{
    use Queueable, SerializesModels;

    public $membership_request_data;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($membership_request_data, $type)
    {
        $this->membership_request_data = $membership_request_data;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        switch($this->type === 'type'){
            case 'success':
                $view_name = 'emails.membership_request_success';
                break;

            case 'failure':
                $view_name = 'emails.membership_request_failure';
                break;

            default:
                $view_name = 'emails.membership_request_success';
                break;
        }
        return $this->from('admin@email.com', 'Admin')
            ->subject('Informacije o zahtjevu za članskom karticom')
            ->view($view_name);
    }
}
