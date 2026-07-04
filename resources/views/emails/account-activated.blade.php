<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your account has been activated</title>
</head>
<body>
    <h2>Your account has been activated</h2>
    <p>Hi {{ $user->firstname }},</p>
    <p>Your account on {{ $appName }} has been activated successfully.</p>
    <p>You can now log in and access your dashboard.</p>
    @if($adminEmail)
        <p>For support, please contact us at {{ $adminEmail }} or {{ $adminPhone }}.</p>
    @else
        <p>For support, please contact us at {{ $adminPhone }}.</p>
    @endif
</body>
</html>
