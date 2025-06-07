<?php

namespace App\Contracts\Api\User;

use App\Models\User;

interface TokenServiceInterface
{
    public function createToken(User $user, string $tokenName): string;
    public function revokeCurrentToken(User $user): void;
}