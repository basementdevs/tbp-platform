<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;


class AuthenticatedUserControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stu
    }

    public function testPutSettings()
    {
        // Arrange
        $this->artisan('db:seed');
        $user = User::factory()
            ->create();

        $user->accounts()->create([
            'provider' => 'twitch',
            'provider_user_id' => '123456',
            'name' => 'John Doe',
            'nickname' => 'johndoe',
            'email' => 'danielhe4rt@gmail.com',
            'phone' => '1234567890',
            'avatar' => 'https://example.com/avatar.jpg',
            'token' => 'access_token',
            'refresh_token' => 'refresh_token',
            'expires_at' => now()->addHour(),
        ]);

        $payload = [
            'user_id' => $user->id,
            'occupation_id' => 2,
            'pronouns' => config('extension.pronouns.She/Her.name'),
        ];

        // Act
        $response = $this
            ->actingAs($user)
            ->putJson(route('auth.update-settings'), $payload);

        // Assert
        $response->assertOk()
            ->assertJsonFragment($payload)
            ->assertJsonStructure(['occupation' => ['id']]);

        $this->assertDatabaseHas('settings', $payload);
    }
}
