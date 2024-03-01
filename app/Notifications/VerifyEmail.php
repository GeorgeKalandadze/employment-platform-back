<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends VerifyEmailBase
{
    public function toMail($notifiable): MailMessage
    {
        $url = env('FRONT_BASE_URL').'/success-verified?email='.urlencode($notifiable->email);

        return (new MailMessage())
            ->subject(('Please verify your email address'))
            ->view(
                'email.email-verification',
                ['url' => $url,
                    'name' => $notifiable->name]
            );
    }
}
