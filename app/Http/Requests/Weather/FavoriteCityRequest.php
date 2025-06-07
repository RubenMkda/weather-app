<?php

namespace App\Http\Requests\Weather;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteCityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city_id' => 'required|exists:cities,id',
        ];
    }
}
