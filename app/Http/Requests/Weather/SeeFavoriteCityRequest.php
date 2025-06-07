<?php

namespace App\Http\Requests\Weather;

use App\Enums\User\PermissionEnum;
use Illuminate\Foundation\Http\FormRequest;

class SeeFavoriteCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can(PermissionEnum::READ_FAVORITE_CITY);
    }

    public function rules(): array
    {
        return [];
    }

    
}