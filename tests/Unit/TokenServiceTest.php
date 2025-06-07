<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\Api\Auth\TokenService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class TokenServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TokenService $tokenService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tokenService = new TokenService();
    }

    public function test_createToken_returns_plain_text_token()
    {
        $tokenMock = (object) ['plainTextToken' => 'test-token'];

        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('createToken')
            ->once()
            ->with('my-token-name')
            ->andReturn($tokenMock);

        $result = $this->tokenService->createToken($userMock, 'my-token-name');

        $this->assertEquals('test-token', $result);
    }

    public function test_revokeCurrentToken_deletes_current_access_token()
    {
        $accessTokenMock = Mockery::mock();
        $accessTokenMock->shouldReceive('delete')->once();

        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('currentAccessToken')
            ->once()
            ->andReturn($accessTokenMock);

        $this->tokenService->revokeCurrentToken($userMock);

        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
