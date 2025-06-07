<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Contracts\Api\User\TokenServiceInterface;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Autenticación y gestión de tokens"
 * )
 */
class LogoutController extends Controller
{
    public function __construct(
        private TokenServiceInterface $tokenService
    ) {}

    /**
     * Logout de usuario.
     *
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Cerrar sesión",
     *     description="Revoca el token de acceso actual del usuario autenticado.",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logout exitoso.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado - token inválido o inexistente"
     *     )
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        $this->tokenService->revokeCurrentToken($user);

        return response()->json([
            'message' => 'Successful logout.
',
        ]);
    }
}
