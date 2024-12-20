<?php

namespace Tests\Unit\app\Models\Settings;

use App\Models\Settings\Occupation;
use App\Models\Settings\Settings;
use Tests\TestCase;

class OccupationTest extends TestCase
{
    public function test_occupation_can_be_created()
    {
        Occupation::factory()->create([
            'name' => 'Developer',
            'slug' => 'developer',
            'translation_key' => 'occupation.developer',
        ]);

        $this->assertDatabaseHas('occupations', [
            'name' => 'Developer',
            'slug' => 'developer',
            'translation_key' => 'occupation.developer',
        ]);
    }

    public function test_image_url_attribute()
    {
        $occupation = Occupation::factory()->create([
            'slug' => 'developer',
        ]);

        $expectedUrl = sprintf('%s/static/icons/developer.png', config('services.consumer-api.base_uri'));

        $this->assertEquals($expectedUrl, $occupation->image_url);
    }

    public function test_occupation_has_many_settings()
    {
        $occupation = Occupation::factory()->create();
        $settings = Settings::factory()->create(['occupation_id' => $occupation->id]);

        $this->assertTrue($occupation->settings->contains($settings));
    }
}
