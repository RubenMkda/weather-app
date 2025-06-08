<?php

namespace Tests\Feature\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Contracts\Api\User\TokenServiceInterface;
use Mockery;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_logout_successfully(): void
    {
        $user = User::factory()->create();
        $tokenServiceMock = Mockery::mock(TokenServiceInterface::class);
        $this->app->instance(TokenServiceInterface::class, $tokenServiceMock);

        $tokenServiceMock
            ->shouldReceive('revokeCurrentToken')
            ->once()
            ->with($user);

        $response = $this->actingAs($user)
                         ->postJson('/api/logout');

        $response->assertOk()
                 ->assertJson([
                     'message' => 'Successful logout.',
                 ]);
    }
}
