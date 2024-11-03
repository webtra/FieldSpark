<?php

namespace App\Mail;

use App\Models\SupportTickets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportTicketNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $userEmail;

    /**
     * Create a new message instance.
     */
    public function __construct(SupportTickets $ticket, $userEmail)
    {
        $this->ticket = $ticket;
        $this->userEmail = $userEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Support Ticket Notification',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to('info@webtra.co.za')
            ->subject('New Support Ticket Created: ' . $this->ticket->ticket_number)
            ->view('emails.support-ticket-notification')
            ->with([
                'ticket' => $this->ticket,
                'userEmail' => $this->userEmail,
            ]);
    }
}
