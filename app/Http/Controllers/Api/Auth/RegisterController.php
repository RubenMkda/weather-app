<?php

namespace App\Http\Controllers\Api\Auth;

use App\Contracts\Api\Auth\UserServiceInterface;
use App\Contracts\Api\User\TokenServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Autenticación y gestión de usuarios"
 * )
 */
class RegisterController extends Controller
{
    public function __construct(
        private UserServiceInterface $userService,
        private TokenServiceInterface $tokenService
    ) {}

    /**
     * Registro de nuevo usuario.
     *
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="Registrar usuario",
     *     description="Crea un nuevo usuario y genera un token de acceso.",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="email", type="string", format="email", example="usuario@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="contraseña123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="contraseña123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario registrado con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     *             @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['lang'] = $request->header('Accept-Language');

        $user = $this->userService->createUser($data);
        $token = $this->tokenService->createToken($user, 'auth_token');

        return response()->json([
            'token' => $token,
            'user'  => new UserResource($user),
        ], 201);
    }
}
