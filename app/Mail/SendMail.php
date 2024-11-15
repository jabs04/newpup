<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailMessage;
    public $mailSubject;
    public $mailLink;
    public $mailEmail;
    public $mailPassword;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $subject, $link, $email, $password)
    {
        $this->mailMessage = $message;
        $this->mailSubject = $subject;
        $this->mailLink = $link;
        $this->mailEmail = $email;
        $this->mailPassword = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->mailSubject)
                    ->view('mails.sendMail');
    }
}