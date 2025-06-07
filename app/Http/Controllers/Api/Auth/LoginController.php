<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Contracts\Api\User\TokenServiceInterface;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(
        private TokenServiceInterface $tokenService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = $request->user();

        $token = $this->tokenService->createToken($user, 'auth_token');

        return response()->json([
            'message' => 'Login exitoso.',
            'user' => $user,
            'token' => $token,
        ]);
    }
}
