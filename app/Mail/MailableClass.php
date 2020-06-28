<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailableClass extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Notificación Automatica';
    public $newUser;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newUser)
    {
        //
        $this->newUser = $newUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->newUser['fdef10'] != null) {
            return $this->view('email-send-limit');
        } else {
            return $this->view('email-send');
        }
    }
}
