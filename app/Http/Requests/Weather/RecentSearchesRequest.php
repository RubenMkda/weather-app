<?php

namespace App\Http\Requests\Weather;

use App\Enums\User\PermissionEnum;
use Illuminate\Foundation\Http\FormRequest;

class RecentSearchesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can(PermissionEnum::CREATE_WEATHER_SEARCH);
    }

    public function rules(): array
    {
        return [
            'city' => 'required|string',
        ];
    }
 
}
