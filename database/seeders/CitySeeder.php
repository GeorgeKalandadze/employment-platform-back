<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            [
                'city' => json_encode(['en' => 'Tbilisi', 'ka' => 'თბილისი']),
            ],
            [
                'city' => json_encode(['en' => 'Qutaisi', 'ka' => 'ქუთაისი']),
            ],
            [
                'city' => json_encode(['en' => 'Batumi', 'ka' => 'ბათუმი']),
            ],
            [
                'city' => json_encode(['en' => 'Foti', 'ka' => 'ფოთი']),
            ],
            [
                'city' => json_encode(['en' => 'Oni', 'ka' => 'ონი']),
            ],
            [
                'city' => json_encode(['en' => 'Mestia', 'ka' => 'მესტია']),
            ],
            [
                'city' => json_encode(['en' => 'Ureki', 'ka' => 'ურეკი']),
            ],
            [
                'city' => json_encode(['en' => 'Qobuleti', 'ka' => 'ქობულეთი']),
            ],
            [
                'city' => json_encode(['en' => 'Ozurgeti', 'ka' => 'ოზურგეთი']),
            ],
        ]);
    }
}
