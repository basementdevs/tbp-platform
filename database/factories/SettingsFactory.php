<?php

namespace Database\Factories;

use App\Models\Settings\Occupation;
use App\Models\Settings\Settings;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SettingsFactory extends Factory
{
    protected $model = Settings::class;

    public function definition()
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'pronouns' => $this->faker->word(),

            'user_id' => User::factory(),
            'occupation_id' => Occupation::factory(),
        ];
    }
}
