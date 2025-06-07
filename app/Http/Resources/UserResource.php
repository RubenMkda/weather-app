<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
/**
 * @OA\Schema(
 *     schema="UserResource",
 *     type="object",
 *     description="Datos del usuario",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Juan Pérez"),
 *     @OA\Property(property="email", type="string", format="email", example="usuario@example.com"),
 *     @OA\Property(property="role", type="string", example="admin"),
 *     @OA\Property(property="language_id", type="integer", example=2),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-07T12:34:56Z")
 * )
 */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->getRoleNames()->first(),
            'language_id' => $this->language_id,
            'created_at' => $this->created_at,
        ];
    }
}
