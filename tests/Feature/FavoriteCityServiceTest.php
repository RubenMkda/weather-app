<?php

namespace Tests\Unit\Services\Api\Weather;

use App\Models\User;
use App\Models\Weather\City;
use App\Models\Weather\FavoriteCity;
use App\Services\Api\Weather\FavoriteCityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class FavoriteCityServiceTest extends TestCase
{
    use RefreshDatabase;

    protected FavoriteCityService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FavoriteCityService();
    }

    public function test_can_create_favorite()
    {
        $user = User::factory()->create();
        $city = City::factory()->create();

        $this->actingAs($user);

        $favorite = $this->service->createFavorite($city->id);

        $this->assertDatabaseHas('favorite_cities', [
            'user_id' => $user->id,
            'city_id' => $city->id,
        ]);

        $this->assertEquals($city->id, $favorite->city_id);
    }

    public function test_can_get_user_favorites()
    {
        $user = User::factory()->create();
        $city = City::factory()->create();

        $this->actingAs($user);

        FavoriteCity::create([
            'user_id' => $user->id,
            'city_id' => $city->id,
        ]);

        $favorites = $this->service->getUserFavorites();

        $this->assertCount(1, $favorites);
        $this->assertEquals($city->id, $favorites->first()->city_id);
    }

    public function test_can_get_favorite_by_id()
    {
        $user = User::factory()->create();
        $city = City::factory()->create();

        $this->actingAs($user);

        $favorite = FavoriteCity::create([
            'user_id' => $user->id,
            'city_id' => $city->id,
        ]);

        $result = $this->service->getFavoriteById($favorite->id);

        $this->assertEquals($favorite->id, $result->id);
    }

    public function test_can_delete_favorite()
    {
        $user = User::factory()->create();
        $city = City::factory()->create();

        $this->actingAs($user);

        $favorite = FavoriteCity::create([
            'user_id' => $user->id,
            'city_id' => $city->id,
        ]);

        $this->service->deleteFavorite($favorite->id);

        $this->assertDatabaseMissing('favorite_cities', ['id' => $favorite->id]);
    }

    public function test_get_favorite_by_id_throws_404_if_not_found()
    {
        $this->expectException(HttpException::class);

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->service->getFavoriteById(999);
    }
}
