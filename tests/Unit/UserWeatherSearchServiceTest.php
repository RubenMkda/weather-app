<?php

namespace Tests\Unit\Services\Api\Weather;

use App\Models\User;
use App\Models\Weather\WeatherSearch;
use App\Services\Api\Weather\UserWeatherSearchService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class UserWeatherSearchServiceTest extends TestCase
{
    public function test_get_recent_searches_returns_collection()
    {
        $user = Mockery::mock(User::class);

        $relation = Mockery::mock(HasMany::class);
        $relation->shouldReceive('with')->with('city')->andReturnSelf();
        
        $searches = collect([
            new WeatherSearch(['id' => 1]),
            new WeatherSearch(['id' => 2]),
        ]);

        $relation->shouldReceive('get')->andReturn($searches);

        $user->shouldReceive('recentWeatherSearches')->andReturn($relation);

        $service = new UserWeatherSearchService();
        $result = $service->getRecentSearches($user);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    
}
