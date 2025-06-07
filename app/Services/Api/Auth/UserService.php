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
        
        if (!empty($data['lang'])) {
            $language = $this->languageRepository->findByCode($data['lang']);
            $data['language_id'] = $language->id;
        }
        
        if (empty($language)) {
            $language = $this->languageRepository->getDefaultLanguage();
            $data['language_id'] = $language->id;
        }
        
        $data['password'] = Hash::make($data['password']);
        
        return User::create($data);
    }
}
