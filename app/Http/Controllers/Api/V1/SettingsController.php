<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Settings\Color;
use App\Models\Settings\Effect;
use App\Models\Settings\Occupation;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    private int $ttl = 60 * 60; // 1 hour

    public function getColors(): JsonResponse
    {
        $cachedColors = cache()->remember('settings-colors', $this->ttl, function () {
            return Color::paginate(15);
        });

        return response()->json($cachedColors);
    }

    public function getEffects(): JsonResponse
    {
        $cachedEffects = cache()->remember('settings-effects', $this->ttl, function () {
            return Effect::paginate(15);
        });

        return response()->json($cachedEffects);
    }

    public function getOccupationsList(): JsonResponse
    {

        $cachedOccupations = cache()->remember('settings-occupations', $this->ttl, function () {
            return Occupation::query()->select(['id', 'name', 'slug', 'translation_key'])->get();
        });

        return response()->json($cachedOccupations);
    }
}
