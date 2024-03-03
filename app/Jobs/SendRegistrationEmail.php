<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Auth\Events\Registered;

class SendRegistrationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $requestData;

    public function __construct(array $requestData)
    {
        $this->requestData = $requestData;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::create($this->requestData);
        event(new Registered($user));
    }
}
