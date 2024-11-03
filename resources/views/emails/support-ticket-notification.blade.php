<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Ticket Notification</title>
</head>

<body>
    <h1>New Support Ticket Created</h1>
    <p><strong>Ticket Number:</strong> {{ $ticket->ticket_number }}</p>
    <p><strong>Category:</strong> {{ $ticket->category }}</p>
    <p><strong>Urgency:</strong> {{ $ticket->urgency }}</p>
    <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
    <p><strong>Message:</strong> {{ $ticket->message }}</p>
    <p><strong>Status:</strong> {{ $ticket->status }}</p>
    <p><strong>User Email:</strong> {{ $userEmail }}</p>
</body>

</html>