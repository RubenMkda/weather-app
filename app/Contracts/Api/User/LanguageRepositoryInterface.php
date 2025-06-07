<?php

namespace App\Contracts\Api\User;

use App\Models\User\Language;

interface LanguageRepositoryInterface
{
  /**
   *
   * @return Language|null
   */
  public function getDefaultLanguage(): ?Language;
}
