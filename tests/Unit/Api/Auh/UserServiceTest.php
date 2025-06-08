<?php

namespace Tests\Unit\Services\Api\Auth;

use App\Contracts\Api\User\LanguageRepositoryInterface;
use App\Enums\User\RoleEnum;
use App\Models\User;
use App\Models\User\Language;
use App\Services\Api\Auth\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mockery;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_user_with_default_language()
    {
        Role::create(['name' => 'user', 'guard_name' => 'web']); 

        $defaultLanguage = Language::factory()->create(['is_default' => true]);

        $languageRepoMock = Mockery::mock(LanguageRepositoryInterface::class);
        $languageRepoMock->shouldReceive('getDefaultLanguage')
            ->andReturn($defaultLanguage);
        $languageRepoMock->shouldReceive('findByCode')
            ->with(null)
            ->andReturn(null);

        $this->app->instance(LanguageRepositoryInterface::class, $languageRepoMock);

        $userService = new UserService($languageRepoMock);

        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123',
        ];

        $user = $userService->createUser($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userData['email'], $user->email);
        $this->assertTrue(Hash::check('secret123', $user->password));
        $this->assertEquals($defaultLanguage->id, $user->language_id);
        $this->assertTrue($user->hasRole(RoleEnum::USER));
    }

    public function test_it_creates_user_with_custom_language()
    {
        Role::create(['name' => 'user', 'guard_name' => 'web']); 

        $customLanguage = Language::factory()->create(['code' => 'es']);
        $languageRepoMock = Mockery::mock(LanguageRepositoryInterface::class);

        $languageRepoMock->shouldReceive('findByCode')
            ->with('es')
            ->andReturn($customLanguage);
        $languageRepoMock->shouldReceive('getDefaultLanguage')
            ->andReturn(Language::factory()->create(['is_default' => true]));

        $this->app->instance(LanguageRepositoryInterface::class, $languageRepoMock);

        $userService = new UserService($languageRepoMock);

        $userData = [
            'name' => 'Ana Pérez',
            'email' => 'ana@example.com',
            'password' => 'contraseña123',
            'lang' => 'es',
        ];

        $user = $userService->createUser($userData);

        $this->assertEquals($customLanguage->id, $user->language_id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
