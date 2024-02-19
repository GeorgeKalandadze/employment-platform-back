<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function testStoreCourseAsUser(): void
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $requestData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => 777,
            'start_date' => '2024-02-18 12:57:31',
            'sub_category_id' => 1,

        ];

        $response = $this->postJson('/api/courses', $requestData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Course created successfully',
            ]);

    }

    public function testStoreCourseAsCompany(): void
    {
        $user = User::factory()->has(Company::factory()->count(1))->create();
        $this->actingAs($user);

        $requestData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => 777,
            'start_date' => '2024-02-18 12:57:31',
            'sub_category_id' => 1,
            'company_id' => $user->companies->first()->id,
        ];

        $response = $this->postJson('/api/courses/store-as-company', $requestData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Course created successfully',
            ]);

        $this->assertDatabaseHas('courses', [
            'title' => $requestData['title'],
            'description' => $requestData['description'],
            'courseable_id' => $requestData['company_id'],
            'courseable_type' => Company::class,
        ]);
    }

    public function testUpdateCourse(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $course = Course::factory()->create(['courseable_id' => $user->id, 'courseable_type' => User::class]);

        $updatedData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'start_date' => now()->addDays(7)->toDateString(),
        ];

        $response = $this->putJson("/api/courses/{$course->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Course updated successfully']);

    }

    public function testDeleteCourse(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $course = Course::factory()->create(['courseable_id' => $user->id, 'courseable_type' => User::class]);

        $response = $this->deleteJson("/api/courses/{$course->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'course deleted successfully']);

    }
}
