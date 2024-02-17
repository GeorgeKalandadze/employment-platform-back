<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        $user_id = auth()->id();

        $validatedData = $request->validated();

        $validatedData['user_id'] = $user_id;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('company-logos', 'public');

            $validatedData['logo'] = $logoPath;
        }

        Company::create($validatedData);

        return response()->json(['message' => 'Company created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): JsonResponse
    {
        if ($company->user_id !== auth()->id()) {
            return response()->json(['error' => 'You are not authorized to delete this company.'], 403);
        }
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return response()->json(['message' => 'Company deleted successfully'], 200);
    }
}
