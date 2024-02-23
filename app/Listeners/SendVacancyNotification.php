<?php

namespace App\Listeners;

use App\Events\NewVacancyAdded;
use App\Notifications\NewVacancyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendVacancyNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewVacancyAdded $event)
    {
        $company = $event->company;
        $vacancy = $event->vacancy;

        $followers = $company->followers;

        foreach ($followers as $follower) {
            $follower->notify(new NewVacancyNotification($company, $vacancy));
        }
    }
}
