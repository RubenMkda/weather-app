<?php

namespace App\Services\Api\Auth;

use App\Contracts\Api\Auth\UserServiceInterface;
use App\Contracts\Api\User\LanguageRepositoryInterface;
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
        $language = $this->languageRepository->getDefaultLanguage();
        $data['language_id'] = $language->id ?? null;

        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }
}
