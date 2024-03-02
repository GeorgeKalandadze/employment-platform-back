<?php

namespace App\Http\Controllers;

use App\Events\NewVacancyAdded;
use App\Http\Requests\ResumeRequest;
use App\Http\Requests\StoreVacancyAsCompanyRequest;
use App\Http\Requests\StoreVacancyAsUserRequest;
use App\Http\Requests\UpdateVacancyRequest;
use App\Http\Resources\VacancyResource;
use App\Models\Company;
use App\Models\Resume;
use App\Models\User;
use App\Models\Vacancy;
use App\Notifications\ResumeSubmittedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        $vacancies = Vacancy::with('subCategory', 'jobType')->get();

        return VacancyResource::collection($vacancies);
    }

    public function storeVacancyAsCompany(StoreVacancyAsCompanyRequest $request)
    {
        $validatedData = $request->validated();

        $company = Company::findOrFail($validatedData['company_id']);
        $vacancy = $company->vacancies()->create($validatedData);

        event(new NewVacancyAdded($company, $vacancy));

        return response()->json(['message' => 'Vacancy created successfully'], 201);
    }

    public function storeVacancyAsUser(StoreVacancyAsUserRequest $request)
    {
        $validatedData = $request->validated();
        $userId = auth()->id();

        $user = User::findOrFail($userId);
        $user->vacancies()->create($validatedData);

        return response()->json(['message' => 'Vacancy created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vacancy $vacancy)
    {
        return new VacancyResource($vacancy);
    }

    /**
     * Update vacancy views
     */
    public function updateViews($id): JsonResponse
    {
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->increment('views_count');

        return response()->json('View count updated');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVacancyRequest $request, Vacancy $vacancy): JsonResponse
    {
        if (! $this->checkAuthorization($vacancy)) {
            return response()->json(['error' => 'You are not authorized to update this vacan$vacancy.'], 403);
        }

        $vacancy->update($request->validated());

        return response()->json(['message' => 'Vacancy updated successfully'], 200);
    }

    public function destroy(Vacancy $vacancy)
    {
        if (! $this->checkAuthorization($vacancy)) {
            return response()->json(['error' => 'You are not authorized to delete this vaca$vacancy.'], 403);
        }

        $vacancy->delete();

        return response()->json(['message' => 'Vacancy deleted successfully'], 200);
    }


    public function submitResume(ResumeRequest $request, Vacancy $vacancy): JsonResponse
    {
        $resumePath = $request->file('resume')->store('resumes');

        $resumeData = [
            'file_path' => $resumePath,
            'vacancy_id' => $vacancy->id,
            'user_id' => auth()->id(),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ];

        $resume = Resume::create($resumeData);

        $vacancyOwner = $vacancy->vacancyable;
        $vacancyOwner->notify(new ResumeSubmittedNotification($vacancy, $resume));

        return response()->json(['message' => 'Resume submitted successfully'], 201);
    }

    /**
     * Check authorization for the given course.
     */
    private function checkAuthorization(Vacancy $vacancy): bool
    {
        $user = auth()->user();
        if ($vacancy->courseable_type === 'App\\Models\\Company' && $vacancy->courseable->user_id !== $user->id) {
            return false;
        } elseif ($vacancy->courseable_type === 'App\\Models\\User' && $vacancy->courseable_id !== $user->id) {
            return false;
        }

        return true;
    }
}
