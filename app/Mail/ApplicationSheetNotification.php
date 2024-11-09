<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationSheetNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $linkMessage;
    public $firstName;
    public $lastName;

    public function __construct($linkMessage, $firstName, $lastName)
    {
        $this->linkMessage = $linkMessage;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function build()
    {
        return $this->view('emails.application_sheet_notification')
            ->with([
                'linkMessage' => $this->linkMessage,
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
            ]);
    }
}
