<?php

namespace App\Models\Weather;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'city_id',
        'searched_at',
        'weather_data',
    ];

    protected $casts = [
        'searched_at' => 'datetime',
        'weather_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
