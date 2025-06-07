<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Contracts\Api\User\TokenServiceInterface;

class LogoutController extends Controller
{
    public function __construct(
        private TokenServiceInterface $tokenService
    ) {}

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        $this->tokenService->revokeCurrentToken($user);

        return response()->json([
            'message' => 'Successful logout.',
        ]);
    }
}
