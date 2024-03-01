<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Vacancy;
use App\Models\Resume;

class ResumeSubmittedNotification extends Notification
{
    use Queueable;

    protected $vacancy;
    protected $resume;

    public function __construct(Vacancy $vacancy, Resume $resume)
    {
        $this->vacancy = $vacancy;
        $this->resume = $resume;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Resume Submitted for ' . $this->vacancy->title)
            ->line('A new resume has been submitted for the vacancy: ' . $this->vacancy->title)
            ->line('Submitted by: ' . $this->resume->first_name . ' ' . $this->resume->last_name)
            ->line('Email: ' . $this->resume->email)
            ->line('Phone: ' . $this->resume->phone)
            ->action('View Vacancy', url('/'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
