<?php

namespace Database\Factories;

use App\Models\Settings\Occupation;
use Illuminate\Database\Eloquent\Factories\Factory;

class OccupationFactory extends Factory
{
    protected $model = Occupation::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->name,
            'translation_key' => $this->faker->name,
        ];
    }
}
