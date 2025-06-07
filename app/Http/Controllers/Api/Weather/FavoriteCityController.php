<?php

namespace App\Http\Controllers\Api\Weather;

use App\Contracts\Api\Weather\FavoriteCityServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Weather\DeleteFavoriteCityRequest;
use App\Http\Requests\Weather\FavoriteCityRequest;
use App\Http\Resources\FavoriteCityResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FavoriteCityController extends Controller
{
    public function __construct(private FavoriteCityServiceInterface $service)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $favorites = $this->service->getUserFavorites();
        return FavoriteCityResource::collection($favorites);
    }

    public function store(FavoriteCityRequest $request): FavoriteCityResource
    {
        $favorite = $this->service->createFavorite((int) $request->city_id);
        return new FavoriteCityResource($favorite);
    }

    public function show(int $id): FavoriteCityResource
    {
        $favorite = $this->service->getFavoriteById($id);
        return new FavoriteCityResource($favorite);
    }

    public function destroy(DeleteFavoriteCityRequest $request, int $id): JsonResponse
    {
        $this->service->deleteFavorite($id);
        return response()->json(['message' => 'Favorito eliminado correctamente']);
    }
}