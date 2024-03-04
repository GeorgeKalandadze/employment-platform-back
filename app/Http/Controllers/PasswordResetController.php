<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Jobs\SendForgotPasswordEmail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        SendForgotPasswordEmail::dispatch($request->validated())->onQueue('forgot');
        return response()->json(['message' => 'Password reset email sent!'], 200);
    }

    public function passwordUpdate(UpdatePasswordRequest $request): JsonResponse
    {
        $status = Password::reset($request->validated(), function ($user, $password) {
            $user->forceFill(['password' => $password]);
            $user->save();
            event(new PasswordReset($user));
        });

        $check_password_is_updated = $status === Password::PASSWORD_RESET;

        $response = $check_password_is_updated ? 'Password updated successfully !' : __($status);

        return response()->json(['message' => $response], $check_password_is_updated ? 200 : 404);
    }
}
