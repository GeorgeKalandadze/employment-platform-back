<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions; // Use DatabaseTransactions trait to rollback database changes after each test

    /** @test */
    public function test_user_can_register()
    {
        $userData = [
            'username' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(200)
            ->assertJson(['msg' => 'Success registered!']);

        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    /** @test */
    public function test_user_can_confirm_email()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $response = $this->postJson('/api/email/verify', ['email' => $user->email]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Success verified']);

        $this->assertNotNull(User::find($user->id)->email_verified_at);
    }

    public function test_login_with_unverified_email()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $response = $this->postJson('/api/login', [
            'username' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    public function test_invalid_login_invalid_email_format()
    {
        $response = $this->postJson('/api/login', [
            'username' => 'invalid_email_format',
            'password' => 'password123',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ]);
    }

    public function test_successful_login_with_username()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/login', [
            'username' => 'testuser',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }

    /** @test */
    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $token = auth()->login($user);

        $response = $this->postJson('/api/logout', [], ['Authorization' => 'Bearer '.$token]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully logged out']);
    }
}
