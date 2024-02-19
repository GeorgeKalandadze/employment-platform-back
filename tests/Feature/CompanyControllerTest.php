<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function testStoreCompany()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'user_id' => $user->id,
            'name' => 'Test Company',
            'logo' => UploadedFile::fake()->create('company_logo.jpg'),
            'address' => '123 Test St',
            'mobile_number' => '1234567890',
            'email' => 'test@example.com',
            'website' => 'http://example.com',
            'description' => 'This is a test company',
        ];

        $response = $this->postJson('/api/companies', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Company created successfully',

            ]);
    }

    public function testUpdateCompany()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create(['user_id' => $user->id]);

        $data = [
            'user_id' => $user->id,
            'name' => 'Test Company',
            'logo' => UploadedFile::fake()->create('company_logo.jpg'),
            'address' => '123 Test St',
            'mobile_number' => '1234567890',
            'email' => 'test@example.com',
            'website' => 'http://example.com',
            'description' => 'This is a test company',
        ];

        $response = $this->putJson("/api/companies/{$company->id}", $data);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Company updated successfully']);

    }

    public function testDeleteCompany()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $company = Company::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/companies/{$company->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Company deleted successfully']);

    }
}
