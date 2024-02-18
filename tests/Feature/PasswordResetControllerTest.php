<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetControllerTest extends TestCase
{
     /** @test */
     public function test_forgot_password_success()
     {
         $user = User::factory()->create();
 
         $response = $this->postJson('/api/forgot-password', ['email' => $user->email]);
 
         $response->assertStatus(200)
                  ->assertJson(['message' => 'Password reset email sent!']);
     }
 
     /** @test */
     public function test_password_update_success()
     {
         $user = User::factory()->create();
         $token = Password::createToken($user);
 
         $response = $this->postJson('/api/reset-password', [
             'email' => $user->email,
             'password' => 'newpassword123',
             'password_confirmation' => 'newpassword123',
             'token' => $token,
         ]);
 
         $response->assertStatus(200)
                  ->assertJson(['message' => 'Password updated successfully !']);
 
         $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
     }
 
     /** @test */
     public function test_password_update_failure_invalid_token()
     {
         $user = User::factory()->create();
 
         $response = $this->postJson('/api/reset-password', [
             'email' => $user->email,
             'password' => 'newpassword123',
             'password_confirmation' => 'newpassword123',
             'token' => 'invalid_token',
         ]);
 
         $response->assertStatus(404)
                  ->assertJson(['message' => 'This password reset token is invalid.']);
     }
 
}
