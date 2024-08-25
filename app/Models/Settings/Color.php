<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    use HasFactory;

    protected $table = 'settings_colors';

    protected $fillable = [
        'name',
        'slug',
        'translation_key',
        'hex',
    ];

    public function settings(): HasMany
    {
        return $this->hasMany(Settings::class);
    }
}
