<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            'Technology' => [
                'Web Development',
                'Mobile Development',
                'Data Science',
                'Machine Learning',
                'Cybersecurity',
                'Artificial Intelligence',
                'Database Management',
                'Network Security',
            ],
            'Health' => [
                'Nutrition',
                'Fitness',
                'Mental Health',
                'Dieting',
                'Yoga',
                'Alternative Medicine',
                'Sports Medicine',
                'Physical Therapy',
            ],
            'Business' => [
                'Entrepreneurship',
                'Finance',
                'Marketing',
                'Management',
                'Sales',
                'Human Resources',
                'Project Management',
                'Business Strategy',
            ],
            'Education' => [
                'Online Learning',
                'Early Childhood Education',
                'Higher Education',
                'Special Education',
                'Language Learning',
                'Educational Technology',
                'Curriculum Development',
                'Adult Education',
            ],
        ];

        foreach ($categories as $categoryName => $subcategories) {
            $category = Category::create(['name' => $categoryName]);
            foreach ($subcategories as $subcategoryName) {
                SubCategory::create([
                    'name' => $subcategoryName,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
