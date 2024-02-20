<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = auth()->user();
        $attributes = $request->validated();

        if ($request->hasFile('avatar_image')) {
            if ($user->avatar_image) {
                Storage::disk('public')->delete($user->avatar_image);
            }
            $attributes['avatar_image'] = $request->file('avatar_image')->store('user-avatars', 'public');
        }

        $user->update($attributes);

        return response()->json('success');
    }
}
