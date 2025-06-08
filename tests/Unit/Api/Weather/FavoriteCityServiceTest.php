<?php

namespace Tests\Unit\Api\Weather;

use App\Models\Weather\FavoriteCity;
use App\Services\Api\Weather\FavoriteCityService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class FavoriteCityServiceTest extends TestCase
{
    protected FavoriteCityService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FavoriteCityService();
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
    
    public function test_getUserFavorites_returns_collection()
    {
        $userId = 1;
    
        Auth::shouldReceive('id')->once()->andReturn($userId);
    
        $favoriteCityMock = Mockery::mock('alias:' . FavoriteCity::class);
    
        $queryMock = Mockery::mock();
        $queryMock->shouldReceive('with')->with('city')->andReturnSelf();
        $queryMock->shouldReceive('get')->andReturn(new Collection(['favorite1', 'favorite2']));
    
        $favoriteCityMock->shouldReceive('where')->with('user_id', $userId)->andReturn($queryMock);
    
        $result = $this->service->getUserFavorites();
    
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    public function test_createFavorite_creates_or_gets_favorite()
    {
        $userId = 1;
        $cityId = 123;

        Auth::shouldReceive('id')->once()->andReturn($userId);

        $favoriteCityMock = Mockery::mock('alias:' . FavoriteCity::class);

        $favorite = new FavoriteCity();
        $favorite->id = 1;
        $favorite->user_id = $userId;
        $favorite->city_id = $cityId;

        $favoriteCityMock->shouldReceive('firstOrCreate')
            ->with(['user_id' => $userId, 'city_id' => $cityId])
            ->andReturn($favorite);

        $result = $this->service->createFavorite($cityId);

        $this->assertInstanceOf(FavoriteCity::class, $result);
        $this->assertEquals($userId, $result->user_id);
        $this->assertEquals($cityId, $result->city_id);
    }

    public function test_getFavoriteById_returns_favorite()
    {
        $userId = 1;
        $favId = 5;
    
        Auth::shouldReceive('id')->once()->andReturn($userId);
    
        $favoriteCityMock = Mockery::mock('alias:' . FavoriteCity::class);
        $queryMock = Mockery::mock();
    
        $queryMock->shouldReceive('where')->with('user_id', $userId)->andReturnSelf();
        $queryMock->shouldReceive('with')->with('city')->andReturnSelf();
    
        $favorite = new FavoriteCity();
        $favorite->id = $favId;
        $favorite->user_id = $userId;
    
        $queryMock->shouldReceive('first')->andReturn($favorite);
    
        $favoriteCityMock->shouldReceive('where')->with('id', $favId)->andReturn($queryMock);
    
        $result = $this->service->getFavoriteById($favId);
    
        $this->assertEquals($favId, $result->id);
        $this->assertEquals($userId, $result->user_id);
    }
    

    public function test_getFavoriteById_throws_404_when_not_found()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $this->expectExceptionMessage('No existe este favorito, intenta agregar la ciudad que buscas');

        $userId = 1;
        $favId = 999;

        Auth::shouldReceive('id')->once()->andReturn($userId);

        $favoriteCityMock = Mockery::mock('alias:' . FavoriteCity::class);
        $queryMock = Mockery::mock();
        $queryMock->shouldReceive('where')->with('user_id', $userId)->andReturnSelf();
        $queryMock->shouldReceive('with')->with('city')->andReturnSelf();
        $queryMock->shouldReceive('first')->andReturn(null);

        $favoriteCityMock->shouldReceive('where')->with('id', $favId)->andReturn($queryMock);

        $this->service->getFavoriteById($favId);
    }

}
