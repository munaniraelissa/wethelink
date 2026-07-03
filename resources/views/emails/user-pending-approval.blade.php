<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your account is under review</title>
</head>
<body>
    <h2>Your account is under review</h2>
    <p>Hi {{ $user->firstname }},</p>
    <p>{{ $signupMessage }}</p>
    <p>Please contact the admin for further assistance.</p>
    <p><strong>Admin phone:</strong> {{ $adminPhone }}</p>
</body>
</html>
