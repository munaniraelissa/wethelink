<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuperAdminNewUserRegistrationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $signupMessage = '')
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New user registration pending approval',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.super-admin-new-user-registration',
            with: [
                'user' => $this->user,
                'adminPhone' => config('app.super_admin_phone', '+250788565520'),
                'signupMessage' => $this->signupMessage,
            ],
        );
    }
}
