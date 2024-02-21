<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobTypes = [
            'Full-time',
            'Part-time',
            'Contract',
            'Freelance',
            'Internship',
            'Temporary',
            'Remote',
        ];

        foreach ($jobTypes as $type) {
            JobType::create(['name' => $type]);
        }
    }
}
