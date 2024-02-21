<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AddToFavoriteTest extends TestCase
{
    use DatabaseTransactions;

    public function testToggleFavoriteCourse()
    {
        $user = User::factory()->create();
        Auth::login($user);
        $course = Course::factory()->create();

        $response = $this->postJson("/api/toggle-favorite-course/{$course->id}");
        $response->assertJson(['message' => 'Course added to favorites']);

        $response = $this->postJson("/api/toggle-favorite-course/{$course->id}");
        $response->assertJson(['message' => 'Course removed from favorites']);
    }


    public function testToggleFavoriteVacancy()
    {
        $user = User::factory()->create();
        Auth::login($user);
        $vacancy = Vacancy::factory()->create();

        $response = $this->postJson("/api/toggle-favorite-vacancy/{$vacancy->id}");
        $response->assertJson(['message' => 'Vacancy added to favorites']);

        $response = $this->postJson("/api/toggle-favorite-vacancy/{$vacancy->id}");
        $response->assertJson(['message' => 'Vacancy removed from favorites']);
    }
}
