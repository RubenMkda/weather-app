<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Contracts\Api\User\TokenServiceInterface;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Autenticación y gestión de tokens"
 * )
 */
class LoginController extends Controller
{
    public function __construct(
        private TokenServiceInterface $tokenService
    ) {}

    /**
     * Login de usuario.
     *
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Iniciar sesión",
     *     description="Autentica al usuario y devuelve un token de acceso.",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="usuario@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="contraseña123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login exitoso."),
     *             @OA\Property(property="user", type="object",
     *                 description="Datos del usuario autenticado",
     *                 example={"id":1,"name":"Juan Pérez","email":"usuario@example.com"}
     *             ),
     *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = $request->user();

        $token = $this->tokenService->createToken($user, 'auth_token');

        return response()->json([
            'message' => 'Successful login.',
            'user' => $user,
            'token' => $token,
        ]);
    }
}
