<?php

namespace Database\Factories;

use App\Models\Settings\Color;
use App\Models\Settings\Effect;
use App\Models\Settings\Occupation;
use App\Models\Settings\Settings;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SettingsFactory extends Factory
{
    protected $model = Settings::class;

    public function definition(): array
    {
        $pronouns = collect(config('extension.pronouns'))->keys()->shuffle()->first();

        return [
            'user_id' => User::factory(),
            'channel_id' => 'global',
            'enabled' => true,
            'color_id' => Color::factory(),
            'effect_id' => Effect::factory(),
            'occupation_id' => Occupation::factory(),
            'pronouns' => $pronouns,
            'timezone' => $this->faker->timezone,
            'locale' => $this->faker->locale(),
            'is_developer' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
