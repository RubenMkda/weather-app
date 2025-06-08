<?php

namespace Tests\Feature\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use App\Contracts\Api\User\TokenServiceInterface;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_returns_successful_response()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);
        
        $tokenServiceMock = Mockery::mock(TokenServiceInterface::class);
        $tokenServiceMock->shouldReceive('createToken')
                         ->with(Mockery::on(fn($u) => $u->is($user)), 'auth_token')
                         ->andReturn('mocked_token');
    
        $this->app->instance(TokenServiceInterface::class, $tokenServiceMock);
    
        $response = $this->postJson('/api/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);
    
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successful login.',
            'user' => $user->toArray(),
            'token' => 'mocked_token',
        ]);
    }
    
}
