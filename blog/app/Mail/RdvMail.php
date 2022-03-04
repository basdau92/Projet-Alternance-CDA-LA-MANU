<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RdvMail extends Mailable
{
    use Queueable, SerializesModels;

    public $label;
    public $beginning;
    public $end;
    public $description;
    public $address;
    public $city;
    public $zipcode;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($label, $beginning, $end, $description, $address, $city, $zipcode)
    {
        $this->label = $label;
        $this->beginning = $beginning;
        $this->end = $end;
        $this->description = $description;
        $this->address = $address;
        $this->city = $city;
        $this->zipcode = $zipcode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Votre rendez-vous avec Immoport')
            ->view('emails.rdv');
    }
}
