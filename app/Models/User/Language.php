<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory;

    protected $table = 'languages';

    protected $fillable = [
        'code',
        'name',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
