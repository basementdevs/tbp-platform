<?php

namespace App\Models\Settings;

use Database\Factories\OccupationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Occupation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'translation_key'];

    public function getImageUrlAttribute(): string
    {
        return asset(sprintf('storage/icons/%s.png', $this->slug));
    }

    protected $appends = [
        'image_url',
    ];

    public function settings(): HasMany
    {
        return $this->hasMany(Settings::class);
    }

    protected static function newFactory(): OccupationFactory
    {
        return OccupationFactory::new();
    }
}
