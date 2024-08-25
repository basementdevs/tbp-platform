<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Clients\Consumer\ConsumerClient;
use App\Models\Settings\Settings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AuthenticatedUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testPutSettings()
    {
        // Arrange
        $this->artisan('db:seed');
        $user = User::factory()->create();

        /**
         * I don't think the right way would be to run a docker compose with
         * the Rust + ScyllaDB (and also Postgres, Redis) just to run the tests,
         * at the same time I'm not a php dev, so there may well be a better solution for this.
         */


//
//        $this->partialMock(ConsumerClient::class, function ($mock) use ($user) {
//            $mock->shouldReceive('updateUser')
//                ->once()
//                ->andReturn(true);
//        });

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
            'enabled' => true,
            'channel_id' => 'global',
            'pronouns' => 'she-her',
        ];

        // Act
        $response = $this
            ->actingAs($user)
            ->putJson(route('auth.update-settings'), $payload);

        // Assert
        $payload['pronouns'] = config('extension.pronouns.'.$payload['pronouns']);
        $response->assertOk()
            ->assertJsonFragment($payload)
            ->assertJsonStructure(['occupation' => ['id']])
            ->assertJsonStructure(['pronouns' => ['name', 'slug', 'translation_key']]);

        $this->assertDatabaseHas('settings', [
            'user_id' => $user->id,
            'occupation_id' => $payload['occupation_id'],
            'pronouns' => 'she-her',
        ]);
    }

    #[DataProvider('settingsDataProvider')]
    public function testGetSettings(?string $payload, int $count)
    {
        // Arrange
        $this->artisan('db:seed');
        $user = User::factory();

        if ($payload) {
            $user = $user->has(Settings::factory(['channel_id' => 'danielhe4rt']), 'settings');
        }

        $user = $user->create();


        // Act
        $response = $this
            ->actingAs($user)
            ->get(route('auth.my-settings', ['channel_id' => $payload]));

        // Assert
        $response
            ->assertOk()
            ->assertJsonCount($count, 'data');
    }


    public static function settingsDataProvider() {
        return [
            'only_global' => [
                'payload' => null,
                'count' => 1,
            ],
            'with_channel' => [
                'payload' => 'danielhe4rt',
                'count' => 2
            ]
        ];
    }
}
