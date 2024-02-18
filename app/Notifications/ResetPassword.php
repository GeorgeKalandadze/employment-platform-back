<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends ResetPasswordBase
{
    public function toMail($notifiable): MailMessage
    {
        $url = env('FRONT_BASE_URL').'/reset-password?token='.$this->token.'&email='.urlencode($notifiable->email);

        return (new MailMessage())
            ->subject('Reset Password')
            ->view(
                'email.reset-message',
                ['url' => $url,
                    'name' => $notifiable->username]
            );
    }
}
