<?php

namespace App\Http\Controllers;

use App\Models\SupportTickets;
use App\Http\Requests\StoreSupportTicketsRequest;
use App\Http\Requests\UpdateSupportTicketsRequest;
use App\Mail\SupportTicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Illuminate\Support\Str;

class SupportTicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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
            $ticketNumber = 'FS-' . strtoupper(Str::random(4));
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


    /**
     * Display the specified resource.
     */
    public function show(SupportTickets $supportTickets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportTickets $supportTickets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupportTicketsRequest $request, SupportTickets $supportTickets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportTickets $supportTickets)
    {
        //
    }
}
