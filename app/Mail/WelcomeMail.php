<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Userwallet;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $userwallet;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Userwallet $userwallet)
    {
        $this->userwallet = $userwallet;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.mails.welcome');
    }
}
