<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoriteResource;
use App\Models\Course;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FavoriteController extends Controller
{

    public function allFavorites(): ResourceCollection
    {
        $user = auth()->user();
        $favorites = $user->favorites()->with('favoritable')->get();

        return FavoriteResource::collection($favorites);
    }

    public function allFavoriteCourses(): ResourceCollection
    {
        $user = auth()->user();
        $favoriteCourses = $user->favorites()->where('favoritable_type', Course::class)->with('favoritable')->get();

        return FavoriteResource::collection($favoriteCourses);
    }

    public function allFavoriteVacancies(): ResourceCollection
    {
        $user = auth()->user();
        $favoriteVacancies = $user->favorites()->where('favoritable_type', Vacancy::class)->with('favoritable')->get();

        return FavoriteResource::collection($favoriteVacancies);
    }

    public function toggleFavoriteCourse(Course $course): JsonResponse
    {
        $user = auth()->user();

        $existingFavorite = $user->favorites()->where('favoritable_id', $course->id)
            ->where('favoritable_type', Course::class)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();

            return response()->json(['message' => 'Course removed from favorites']);
        } else {
            $user->favorites()->create([
                'favoritable_id' => $course->id,
                'favoritable_type' => Course::class,
            ]);

            return response()->json(['message' => 'Course added to favorites']);
        }
    }

    public function toggleFavoriteVacancy(Vacancy $vacancy): JsonResponse
    {
        $user = auth()->user();

        $existingFavorite = $user->favorites()->where('favoritable_id', $vacancy->id)
            ->where('favoritable_type', Vacancy::class)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();

            return response()->json(['message' => 'Vacancy removed from favorites']);
        } else {
            $user->favorites()->create([
                'favoritable_id' => $vacancy->id,
                'favoritable_type' => Vacancy::class,
            ]);

            return response()->json(['message' => 'Vacancy added to favorites']);
        }
    }
}
