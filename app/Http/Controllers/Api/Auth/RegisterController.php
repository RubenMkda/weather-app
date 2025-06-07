<?php

namespace App\Http\Controllers\Api\Auth;

use App\Contracts\Api\Auth\UserServiceInterface;
use App\Contracts\Api\User\TokenServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(
        private UserServiceInterface $userService,
        private TokenServiceInterface $tokenService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['lang'] = $request->header('Accept-Language');

        $user = $this->userService->createUser($data);
        $token = $this->tokenService->createToken($user, 'auth_token');

        return response()->json([
            'token' => $token,
            'user'  => new UserResource($user),
        ]);
    }
}