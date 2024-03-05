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
        $users = User::all();
        $companies = Company::all();

        $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
        $endOfWeek = Carbon::now()->endOfWeek()->toDateString();


        foreach($users as $user) {

            $newVacancies = $user->vacancies()
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();

            $reportData = [
                'creator' => $user->username,
                'new_vacancies_count' => $newVacancies->count(),
                'views_count' => $newVacancies->sum('views_count')
            ];

            Mail::to($user->email)->send(new WeeklyReportMail($reportData));
        }
        foreach($companies as $company) {

            $newVacancies = $company->vacancies()
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();
            $newFollowers = $company->followers()
           
            ->get();

            $reportData = [   
                'creator' => $company->name,
                'new_vacancies_count' => $newVacancies->count(),
                'views_count' => $newVacancies->sum('views_count'),
                'new_followers' => $newFollowers->count()
            ];


            Mail::to($company->email)->send(new WeeklyReportMail($reportData));
        }
    }
}
