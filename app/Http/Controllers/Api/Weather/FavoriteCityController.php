<?php

namespace App\Http\Controllers\Api\Weather;

use App\Contracts\Api\Weather\FavoriteCityServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Weather\DeleteFavoriteCityRequest;
use App\Http\Requests\Weather\FavoriteCityRequest;
use App\Http\Requests\Weather\SeeFavoriteCityRequest;
use App\Http\Resources\FavoriteCityResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


/**
 * @OA\Schema(
 *     schema="FavoriteCity",
 *     type="object",
 *     title="FavoriteCity",
 *     required={"id", "city_id", "name", "user_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="city_id",
 *         type="integer",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Madrid"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         example=42
 *     )
 * )
 */

class FavoriteCityController extends Controller
{
    public function __construct(private FavoriteCityServiceInterface $service)
    {
    }

    /**
     * 
     * @OA\Get(
     *     path="/api/favorites",
     *     summary="Listar ciudades favoritas del usuario",
     *     description="Devuelve la lista de ciudades favoritas asociadas al usuario autenticado",
     *     tags={"Ciudades Favoritas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de ciudades favoritas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/FavoriteCity")
     *         )
     *     )
     * )
     */
    public function index(SeeFavoriteCityRequest $request): AnonymousResourceCollection
    {
        $favorites = $this->service->getUserFavorites();
        return FavoriteCityResource::collection($favorites);
    }


    /**
     * @OA\Post(
     *     path="/api/favorites",
     *     summary="Agregar una ciudad a favoritos",
     *     description="Permite al usuario agregar una ciudad a su lista de favoritas",
     *     tags={"Ciudades Favoritas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"city_id"},
     *             @OA\Property(property="city_id", type="integer", example=123)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ciudad favorita creada",
     *         @OA\JsonContent(ref="#/components/schemas/FavoriteCity")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Ciudad ya añadida o inválida"
     *     )
     * )
     */
    public function store(FavoriteCityRequest $request): FavoriteCityResource
    {
        $favorite = $this->service->createFavorite((int) $request->city_id);
        return new FavoriteCityResource($favorite);
    }


    /**
     * @OA\Get(
     *     path="/api/favorites/{id}",
     *     summary="Ver ciudad favorita por ID",
     *     description="Devuelve los detalles de una ciudad favorita específica",
     *     tags={"Ciudades Favoritas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la ciudad favorita",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la ciudad favorita",
     *         @OA\JsonContent(ref="#/components/schemas/FavoriteCity")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ciudad favorita no encontrada"
     *     )
     * )
     */
    public function show(SeeFavoriteCityRequest $request, int $id): FavoriteCityResource
    {
        $favorite = $this->service->getFavoriteById($id);
        return new FavoriteCityResource($favorite);
    }

    /**
     * @OA\Delete(
     *     path="/api/favorites/{id}",
     *     summary="Eliminar una ciudad favorita",
     *     description="Elimina una ciudad favorita del usuario autenticado",
     *     tags={"Ciudades Favoritas"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la ciudad favorita a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ciudad favorita eliminada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Favorito eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ciudad favorita no encontrada"
     *     )
     * )
     */
    public function destroy(DeleteFavoriteCityRequest $request, int $id): JsonResponse
    {
        $this->service->deleteFavorite($id);
        return response()->json(['message' => 'Favorite deleted successfully']);
    }
}