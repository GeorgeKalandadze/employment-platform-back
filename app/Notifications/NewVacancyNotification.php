<?php

namespace App\Notifications;

use App\Models\Company;
use App\Models\Vacancy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewVacancyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $company;

    protected $vacancy;

    public function __construct(Company $company, Vacancy $vacancy)
    {
        $this->company = $company;
        $this->vacancy = $vacancy;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('A new vacancy has been added by '.$this->company->name)
            ->line('Title: '.$this->vacancy->title)
            ->line('Description: '.$this->vacancy->description)
            ->action('View Vacancy', url('/vacancies/'.$this->vacancy->id))
            ->line('Thank you for using our application!');
    }
}
