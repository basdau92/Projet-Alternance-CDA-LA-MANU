<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExceptionOccured extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $mail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content , $mail)
    {
        $this->content = $content;
        $this->mail = $mail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('There was an error in your Laravel App')
            ->view('emails.exception');
    }
}
