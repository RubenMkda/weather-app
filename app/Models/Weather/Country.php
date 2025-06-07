<?php

namespace App\Models\Weather;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'country_id');
    }
    
}
