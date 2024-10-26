<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Our Application</title>
</head>

<body>
    <h1>Welcome, {{ $user->first_name }}!</h1>

    <p>Thank you for joining our application. We are excited to have you on board.</p>

    <p>Before logging in, please reset your password by clicking the link below:</p>
    <a href="{{ route('password.request') }}">Reset your password</a>

    <p>After resetting your password, you can log in to your account using the following link:</p>
    <a href="{{ route('login') }}">Log in to your account</a>

    <p>If you have any questions, feel free to contact us at support@webtra.co.za.</p>

    <p>Best regards,<br>Your Application Team</p>
</body>

</html>