<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Settings\ChatEffectsSeeder;
use Database\Seeders\Settings\OccupationSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(OccupationSeeder::class);
        $this->call(ChatEffectsSeeder::class);

        \Artisan::call('app:ges');
    }
}
