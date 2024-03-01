<?php

namespace App\Events;

use App\Models\Company;
use App\Models\Vacancy;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewVacancyAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $company;

    public $vacancy;

    public function __construct(Company $company, Vacancy $vacancy)
    {
        $this->company = $company;
        $this->vacancy = $vacancy;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
