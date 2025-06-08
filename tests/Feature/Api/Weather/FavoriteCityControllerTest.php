<?php

namespace Tests\Feature\Api\Weather;

use App\Models\User;
use App\Models\Weather\City;
use App\Models\Weather\FavoriteCity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class FavoriteCityControllerTest extends TestCase
{
    use RefreshDatabase;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'read favorite_city', 'guard_name' => 'web']);
        Permission::create(['name' => 'create favorite_city', 'guard_name' => 'web']);
        Permission::create(['name' => 'delete favorite_city', 'guard_name' => 'web']);

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_user_can_see_favorite_cities()
    {
        $city = City::factory()->create();
        FavoriteCity::factory()->create([
            'user_id' => $this->user->id,
            'city_id' => $city->id,
        ]);

        $this->user->givePermissionTo('read favorite_city');

        $response = $this->getJson('/api/favorites');

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    ['id', 'city_id']
                ]
            ]);
    }

    public function test_user_can_add_favorite_city()
    {
        $city = City::factory()->create();

        $this->user->givePermissionTo('create favorite_city');

        $response = $this->postJson('/api/favorites', [
            'city_id' => $city->id,
        ]);

        $response->assertCreated()
            ->assertJsonStructure(['data' => ['id', 'city_id']]);

        $this->assertDatabaseHas('favorite_cities', [
            'user_id' => $this->user->id,
            'city_id' => $city->id,
        ]);
    }

    public function test_city_id_is_required()
    {
        $this->user->givePermissionTo('create favorite_city');

        $response = $this->postJson('/api/favorites', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['city_id']);
    }

    public function test_user_can_view_single_favorite()
    {
        $this->user->givePermissionTo('read favorite_city');

        $city = City::factory()->create();
        $favorite = FavoriteCity::factory()->create([
            'user_id' => $this->user->id,
            'city_id' => $city->id,
        ]);

        $response = $this->getJson("/api/favorites/{$favorite->id}");

        $response->assertOk()
            ->assertJson(['data' => ['id' => $favorite->id]]);
    }

    public function test_user_can_delete_favorite()
    {
        $this->user->givePermissionTo('delete favorite_city');

        $favorite = FavoriteCity::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->deleteJson("/api/favorites/{$favorite->id}");

        $response->assertOk()
            ->assertJson(['message' => 'Favorite successfully deleted']);

        $this->assertDatabaseMissing('favorite_cities', ['id' => $favorite->id]);
    }

    public function test_user_cannot_delete_other_users_favorite()
    {
        $user = User::factory()->create();
        $user->givePermissionTo('delete favorite_city');
    
        $this->actingAs($user);
    
        $otherUser = User::factory()->create();
    
        $favorite = FavoriteCity::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->deleteJson("/api/favorites/{$favorite->id}");
    
        $response->assertStatus(403);
    }
    
}