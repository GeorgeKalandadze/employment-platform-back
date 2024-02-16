<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   public function register(RegisterUserRequest $request): JsonResponse
   {
        $user = User::create($request->validated());
        event(new Registered($user));

        return response()->json(['msg' => 'Success registered!' ]);
   }

   public function verify(VerifyEmailRequest $request): JsonResponse
   {
       $user = User::where('email', $request->email)->firstOrFail();

       if (!$user->hasVerifiedEmail()) {
           $user->markEmailAsVerified();
       }

       return response()->json(['message' => 'Success verified']);
   }
}
