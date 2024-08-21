<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
