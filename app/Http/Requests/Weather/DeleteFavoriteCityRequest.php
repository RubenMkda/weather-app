<?php

namespace App\Http\Requests\Weather;

use App\Models\Weather\FavoriteCity;
use Illuminate\Foundation\Http\FormRequest;

class DeleteFavoriteCityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        $favorite = FavoriteCity::findOrFail($this->route('id'));
        return $favorite->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];
    }
}
