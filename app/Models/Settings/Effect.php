<?php

namespace App\Models\Settings;

use Database\Factories\EffectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Effect extends Model
{
    use HasFactory;

    protected $table = 'settings_effects';

    protected $fillable = [
        'name',
        'slug',
        'translation_key',
        'class_name',
        'hex',
    ];

    public function settings(): HasMany
    {
        return $this->hasMany(Settings::class);
    }

    protected static function newFactory(): EffectFactory
    {
        return EffectFactory::new();
    }
}
