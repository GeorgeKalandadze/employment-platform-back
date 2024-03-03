<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Http\Resources\UserResource;
use App\Jobs\SendRegistrationEmail;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        SendRegistrationEmail::dispatch($request->validated())->onQueue('registration');

        return response()->json(['msg' => 'Success registered!']);
    }

    public function verify(VerifyEmailRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->firstOrFail();

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response()->json(['message' => 'Success verified']);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $username = $validatedData['username'];
        $password = $validatedData['password'];

        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $username, 'password' => $password];
        } else {
            $credentials = ['username' => $username, 'password' => $password];
        }

        if (! auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $isVerifiedEmail = auth()->user()->email_verified_at;

        if (! $isVerifiedEmail) {
            return response()->json(['error' => 'Email not verified'], 401);
        }

        $token = auth()->attempt($credentials);

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    public function user()
    {
        $user = auth()->user();

        return UserResource::make($user);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
