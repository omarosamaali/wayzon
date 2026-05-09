<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Password;

class WelcomeMerchantMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $resetLink;

    public function __construct(
        public User $user,
        string $password = '',
    ) {
        $token = Password::createToken($user);
        $this->resetLink = url('/reset-password/' . $token . '?email=' . urlencode($user->email));
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'مرحباً بك في Wayzon — تم ربط متجرك بنجاح 🎉');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.welcome-merchant');
    }
}
