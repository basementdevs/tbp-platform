<?php

namespace Database\Seeders\Settings;

use App\Models\Settings\Color;
use App\Models\Settings\Effect;
use Illuminate\Database\Seeder;

class ChatEffectsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('extension.colors') as $occupation) {
            Color::create($occupation);
        }

        foreach (config('extension.effects') as $occupation) {
            Effect::create($occupation);
        }
    }
}
