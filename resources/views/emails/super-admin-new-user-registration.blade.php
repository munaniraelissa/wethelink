<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New user registration pending approval</title>
</head>
<body>
    <h2>New user registration requires approval</h2>
    <p>A new user has registered and is waiting for approval.</p>
    <p><strong>Name:</strong> {{ $user->firstname }} {{ $user->lastname }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Telephone:</strong> {{ $user->telephone }}</p>
    <p><strong>Company:</strong> {{ $user->company?->name ?? 'N/A' }}</p>
    <p>{{ $signupMessage }}</p>
    <p>Please review the account and approve or reject it as appropriate.</p>
    <p>Super admin contact phone: {{ $adminPhone }}</p>
</body>
</html>
