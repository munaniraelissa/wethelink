<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Contact Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #0d6efd;
            color: white;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: white;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #0d6efd;
        }
        .message-text {
            background-color: #f5f5f5;
            padding: 15px;
            border-left: 4px solid #0d6efd;
            margin-top: 10px;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Message from Wethelink</h2>
        </div>
        
        <div class="content">
            <div class="field">
                <span class="label">Name:</span> {{ $name }}
            </div>
            
            <div class="field">
                <span class="label">Email:</span> {{ $email }}
            </div>
            
            <div class="field">
                <span class="label">Subject:</span> {{ $subject }}
            </div>
            
            <div class="field">
                <span class="label">Message:</span>
                <div class="message-text">
                    {!! nl2br(e($message)) !!}
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>This message was sent from the Wethelink contact form.</p>
            <p>&copy; {{ date('Y') }} Wethelink. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
