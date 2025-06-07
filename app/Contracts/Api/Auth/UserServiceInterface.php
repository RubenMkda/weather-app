<?php

namespace App\Contracts\Api\Auth;

use App\Models\User;

interface UserServiceInterface
{
    public function createUser(array $data): User;
}