<?php

namespace App\Services\Api\Auth;

use App\Contracts\Api\User\TokenServiceInterface;
use App\Models\User;

class TokenService implements TokenServiceInterface
{
    public function createToken(User $user, string $tokenName): string
    {
        return $user->createToken($tokenName)->plainTextToken;
    }

    public function revokeCurrentToken(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
