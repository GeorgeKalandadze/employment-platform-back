<?php

namespace Database\Factories;

use App\Models\SubCategory;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacancy>
 */
class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Vacancy::class;


    public function definition(): array
    {
        $subcategoryIds = SubCategory::pluck('id')->toArray();
        $jobTypeIds = SubCategory::pluck('id')->toArray();

        return [
            'sub_category_id' => $this->faker->randomElement($subcategoryIds),
            'job_type_id' => $this->faker->randomElement($jobTypeIds),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'salary' => $this->faker->randomFloat(2, 1000, 10000),
            'experience_years' => $this->faker->numberBetween(0, 20), 
            'vacancyable_id' => function () {
                return 1;
            },
            'vacancyable_type' => function () {
                return 'App\\Models\\User';
            },
        ];
    }
}
