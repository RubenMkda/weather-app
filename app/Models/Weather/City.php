<?php

namespace App\Models\Weather;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_code',
        'latitude',
        'longitude',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function weatherSearches(): HasMany
    {
        return $this->hasMany(WeatherSearch::class);
    }

    public function favoriteCities(): HasMany
    {
        return $this->hasMany(FavoriteCity::class);
    }
}
