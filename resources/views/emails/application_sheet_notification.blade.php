<!DOCTYPE html>
<html>
<head>
    <title>Application Sheet Notification</title>
</head>
<body>
<p>Dear {{ $firstName }} {{ $lastName }},</p>
<p>The application sheet for the program "{{ $program->name }}" with a planned application date of {{ $program->planned_application_date->format('Y-m-d') }} is ready for you to fill in.</p>
<p>Please use the following link to access and complete the application sheet:</p>
<p><a href="{{ $link }}">Fill in the Application Sheet</a></p>
<p>Thank you!</p>
</body>
</html>
