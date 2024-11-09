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

    public $link;
    public $firstName;
    public $lastName;

    public function __construct($link, $firstName, $lastName)
    {
        $this->link = $link;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function build()
    {
        return $this->subject('Fill in the Application Sheet')
                    ->view('emails.application_sheet_notification')
                    ->with([
                        'link' => $this->link,
                        'firstName' => $this->firstName,
                        'lastName' => $this->lastName,
                    ]);
    }
}
