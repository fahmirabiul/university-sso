<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Authenticate the user and generate a Passport token.
     *
     * @param array<string, string> $credentials
     * @return array<string, mixed>|null
     */
    public function authenticate(array $credentials): ?array
    {
        if (!Auth::attempt($credentials)) {
            return null;
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->is_active) {
            return null;
        }

        $token = $user->createToken('SSO-Token')->accessToken;

        return [
            'user' => $user->load('profile', 'roles'),
            'access_token' => $token,
        ];
    }
}
