<?php

namespace Database\Factories;

use App\Models\Settings\Color;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ColorFactory extends Factory
{
    protected $model = Color::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'translation_key' => $this->faker->word(),
            'hex' => $this->faker->word(),
        ];
    }
}
