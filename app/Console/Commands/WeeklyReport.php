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
    protected $description = 'Command description';

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

            $newPosts = $users->vacancies()
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();

            $reportData = [
                'username' => $user->name,
            ];


            Mail::to($user->email)->send(new WeeklyReportMail($reportData));
        }
        foreach($companies as $company) {

            $newPosts = $company->vacancies()
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();

            $reportData = [
                'comany_name' => $company->name,
                // Add more report data as needed
            ];

            Mail::to($user->email)->send(new WeeklyReportMail($reportData));
        }
    }
}
