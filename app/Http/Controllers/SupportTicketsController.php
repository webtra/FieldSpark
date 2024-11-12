<?php

namespace App\Http\Controllers;

use App\Models\SupportTickets;
use App\Http\Requests\StoreSupportTicketsRequest;
use App\Http\Requests\UpdateSupportTicketsRequest;
use App\Mail\SupportTicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Illuminate\Support\Str;

class SupportTicketsController extends Controller
{
    public function index()
    {
        // Ensure only authenticated user's tickets are fetched
        $userId = Auth::id();
        $supportTickets = SupportTickets::where('user_id', $userId)->get();
        $supportTicketsCount = $supportTickets->count();

        return Inertia::render('SupportTickets/Index', [
            'supportTickets' => $supportTickets,
            'supportTicketsCount' => $supportTicketsCount,
            'pageTitle' => 'Support Ticket Management'
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'category' => 'required|string',
            'urgency' => 'required|string',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Generate a unique ticket number
        do {
            $ticketNumber = 'FS-' . mt_rand(1000, 9999);
        } while (SupportTickets::where('ticket_number', $ticketNumber)->exists());

        // Create the support ticket
        $ticket = SupportTickets::create([
            'user_id' => Auth::id(),
            'ticket_number' => $ticketNumber,
            'category' => $request->category,
            'urgency' => $request->urgency,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'Open',
        ]);

        // Send an email with ticket details
        $userEmail = Auth::user()->email;
        Mail::to('info@webtra.co.za')->send(new SupportTicketNotification($ticket, $userEmail));

        return response()->json([
            'message' => 'Support ticket created successfully',
            'ticket' => $ticket,
        ], 201);
    }

    public function show($id)
    {
        // Retrieve the ticket with the user who created it and replies with their users
        $ticket = SupportTickets::with(['user', 'replies.user'])->findOrFail($id);

        // Log::info($ticket->toArray());

        // Return a view for displaying the ticket details
        return Inertia::render('SupportTickets/Show', [
            'ticket' => $ticket,
            'pageTitle' => 'Support Ticket Details'
        ]);
    }

    public function reply($id, Request $request)
    {
        // Find the ticket by ID
        $ticket = SupportTickets::findOrFail($id);

        // Validate the request, using 'reply' as the key from the frontend
        $validated = $request->validate([
            'reply_message' => 'required|string',
        ]);

        // Create a new reply, ensuring `ticket_id`, `reply_message`, and `user_id` are saved correctly
        $reply = $ticket->replies()->create([
            'ticket_id' => $ticket->id,                  // Save the associated ticket ID
            'reply_message' => $validated['reply_message'],      // Use `reply_message` as per database column
            'user_id' => auth()->id(),                   // Save the authenticated user's ID
        ]);

        return response()->json(['message' => 'Reply added successfully', 'reply' => $reply], 200);
    }

    public function close($id)
    {
        $ticket = SupportTickets::findOrFail($id);
        $ticket->update(['status' => 'Closed', 'is_closed' => true]);

        return response()->json(['message' => 'Ticket closed successfully']);
    }
}
