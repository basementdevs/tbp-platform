<?php

namespace App\Models\Settings;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'occupation_id',
        'pronouns',
        'timezone',
        'locale',
        'is_developer',
    ];

    protected $casts = [
        'is_developer' => 'boolean',
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
}
