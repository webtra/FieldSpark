<!DOCTYPE html>
<html>
<head>
    <title>Application Sheet Notification</title>
</head>
<body>
    <p>Dear {{ $firstName }} {{ $lastName }},</p>
    <p>Please fill in the application sheet using the following link:</p>
    <p><a href="{{ $link }}">Fill in the Application Sheet</a></p>
    <p>Thank you!</p>
</body>
</html>
