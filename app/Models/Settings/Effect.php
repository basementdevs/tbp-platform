<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
