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
    public $program;

    public function __construct($link, $firstName, $lastName, $program)
    {
        $this->link = $link;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->program = $program;
    }

    public function build()
    {
        return $this->subject('Fill in the Application Sheet')
            ->view('emails.application_sheet_notification')
            ->with([
                'link' => $this->link,
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'program' => $this->program,
            ]);
    }
}
