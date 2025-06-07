<?php

namespace App\Http\Controllers\Api\Weather;

use App\Contracts\Api\Weather\WeatherSearchRecorderInterface;
use App\Contracts\Api\Weather\WeatherServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Weather\RecentSearchesRequest;
use App\Http\Requests\Weather\SearchWeatherRequest;
use App\Http\Resources\WeatherResource;
use App\Http\Resources\WeatherSearchResource;
use App\Services\Api\Weather\UserWeatherSearchService;

/**
 * @OA\Tag(
 *     name="Weather",
 *     description="Operaciones relacionadas con el clima"
 * )
 */
class WeatherController extends Controller  
{
    public function __construct(
        private WeatherServiceInterface $weatherService,
        private WeatherSearchRecorderInterface $searchRecorder,
        private UserWeatherSearchService $userWeatherSearchService
    ) {
    }

    /**
     * Buscar el clima para una ciudad específica.
     *
     * @OA\Post(
     *     path="/api/weather/search",
     *     summary="Buscar el clima",
     *     description="Obtiene el clima actual para una ciudad dada y registra la búsqueda.",
     *     tags={"Weather"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"city"},
     *             @OA\Property(
     *                 property="city",
     *                 type="string",
     *                 example="Madrid",
     *                 description="Nombre de la ciudad para buscar el clima"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Clima encontrado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/WeatherResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validación fallida"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function search(SearchWeatherRequest $request)
    {
        $cityName = $request->input('city');

        $user = $request->user();
        $language = $user->language->code ?? $request->header('Accept-Language', 'en');

        $weatherData = $this->weatherService->getWeather($cityName, $language);

        $countryName = $weatherData['location']['country'];
        $this->searchRecorder->record($weatherData, $cityName, $countryName);

        return new WeatherResource(collect($weatherData));
    }

    /**
     *
     * @OA\Get(
     *     path="/api/weather/recent-searches",
     *     summary="Búsquedas recientes",
     *     description="Obtiene las búsquedas recientes de clima hechas por el usuario autenticado.",
     *     tags={"Weather"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de búsquedas recientes",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/WeatherSearchResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function recentSearches(RecentSearchesRequest $request)
    {
        $user = $request->user();

        $searches = $this->userWeatherSearchService->getRecentSearches($user);

        return WeatherSearchResource::collection($searches);
    }
}
