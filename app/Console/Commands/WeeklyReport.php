<?php

namespace App\Console\Commands;

use App\Mail\WeeklyReportMail;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class WeeklyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:weekly-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a user activity report every week';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
        $endOfWeek = Carbon::now()->endOfWeek()->toDateString();

        $users = User::all();
        $companies = Company::all();

        foreach ($users as $user) {
            $this->sendWeeklyReport($user, $startOfWeek, $endOfWeek);
        }

        foreach ($companies as $company) {
            $this->sendWeeklyReport($company, $startOfWeek, $endOfWeek);
        }
    }

    private function sendWeeklyReport($entity, $startOfWeek, $endOfWeek)
    {
        $newVacancies = $entity->vacancies()
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();

        $reportData = [
            'creator' => $entity instanceof User ? $entity->username : $entity->name,
            'new_vacancies_count' => $newVacancies->count(),
            'views_count' => $newVacancies->sum('views_count'),
        ];

        if ($entity instanceof Company) {
            $newFollowers = $entity->followers()->get();
            $reportData['new_followers'] = $newFollowers->count();
        }

        Mail::to($entity->email)->send(new WeeklyReportMail($reportData));
    }
}
