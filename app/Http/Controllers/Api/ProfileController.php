<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Get the authenticated user's profile.
     */
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'                  => 'sometimes|string|max:255',
            'email'                 => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
            'password'              => 'sometimes|min:6|confirmed',
            'current_password'      => 'required_with:password',
        ]);

        if (isset($data['password'])) {
            if (!\Illuminate\Support\Facades\Hash::check($data['current_password'], $user->password)) {
                return response()->json(['message' => 'Current password is incorrect.'], 422);
            }
            $data['password'] = bcrypt($data['password']);
        }

        unset($data['current_password']);
        $user->update($data);

        return response()->json($user->fresh());
    }
}
