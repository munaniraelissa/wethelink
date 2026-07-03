<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserPendingApprovalMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public User $user, public string $signupMessage = '')
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your account is under review',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user-pending-approval',
            with: [
                'user' => $this->user,
                'adminPhone' => config('app.super_admin_phone', '+250788565520'),
                'signupMessage' => $this->signupMessage,
            ],
        );
    }
}
