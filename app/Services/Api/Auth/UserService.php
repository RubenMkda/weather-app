<?php

namespace App\Services\Api\Auth;

use App\Contracts\Api\Auth\UserServiceInterface;
use App\Contracts\Api\User\LanguageRepositoryInterface;
use App\Enums\User\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    protected $languageRepository;

    public function __construct(LanguageRepositoryInterface $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function createUser(array $data): User
    {
        $data['language_id'] = $this->resolveLanguageId($data['lang'] ?? null);
        
        $data['password'] = Hash::make($data['password']);
        
        $user = User::create($data);

        $user->assignRole(RoleEnum::USER);

        return $user;
    }

    private function resolveLanguageId(?string $lang): int
    {
        if (empty($lang)) {
            return $this->languageRepository->getDefaultLanguage()->id;
        }

        $language = $this->languageRepository->findByCode($lang);

        if (!$language) {
            return $this->languageRepository->getDefaultLanguage()->id;
        }

        return $language->id;
    }

}
