<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subcategoryIds = SubCategory::pluck('id')->toArray();
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'start_date' => now(),
            'sub_category_id' => $this->faker->randomElement($subcategoryIds),
            'courseable_id' => function () {
                return 1;
            },
            'courseable_type' => function () {

                return 'App\\Models\\User';
            },
        ];
    }
}
