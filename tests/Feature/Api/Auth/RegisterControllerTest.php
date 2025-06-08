<?php

namespace Tests\Feature\Api\Auth;

use App\Enums\User\RoleEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\LanguageSeeder;
use Spatie\Permission\Models\Role;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => RoleEnum::USER, 'guard_name' => 'web']); 
        $this->seed(LanguageSeeder::class);
    }

    public function test_user_can_register_successfully()
    {
        $headers = [
            'Accept' => 'application/json',
            'Accept-Language' => 'es',
        ];

        $payload = [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ];

        $response = $this->postJson('/api/register', $payload, $headers);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'token',
                     'user' => [
                         'id',
                         'name',
                         'email',
                     ],
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'juan@example.com',
        ]);

        $user = User::where('email', 'juan@example.com')->first();
        $this->assertTrue($user->hasRole(RoleEnum::USER));
    }

    public function test_register_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'password']);
    }
}
