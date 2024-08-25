<?php

namespace App\Models\Settings;

use App\Models\User;
use Database\Factories\SettingsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $channel_id
 * @property bool $enabled
 */
class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'enabled',
        'channel_id',
        'color_id',
        'effect_id',
        'occupation_id',
        'pronouns',
        'timezone',
        'locale',
        'is_developer',
    ];

    protected $casts = [
        'is_developer' => 'boolean',
        'enabled' => 'boolean',
    ];

    public function getPronounsAttribute(): array
    {
        return config('extension.pronouns.'.$this->attributes['pronouns']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function occupation(): BelongsTo
    {
        return $this->belongsTo(Occupation::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function effect(): BelongsTo
    {
        return $this->belongsTo(Effect::class);
    }

    protected static function newFactory(): SettingsFactory
    {
        return SettingsFactory::new();
    }
}
