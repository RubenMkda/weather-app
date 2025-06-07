<?php

namespace App\Repositories\Api;

use App\Contracts\Api\User\LanguageRepositoryInterface;
use App\Models\User\Language;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function getDefaultLanguage(): ?Language
    {
        return Language::where('is_default', true)->first();
    }
}
