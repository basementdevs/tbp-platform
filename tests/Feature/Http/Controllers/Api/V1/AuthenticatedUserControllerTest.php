<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Clients\Consumer\ConsumerClient;
use App\Models\Settings\Color;
use App\Models\Settings\Effect;
use App\Models\Settings\Occupation;
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

        $user = User::factory()->create();

        /**
         * I don't think the right way would be to run a docker compose with
         * the Rust + ScyllaDB (and also Postgres, Redis) just to run the tests,
         * at the same time I'm not a php dev, so there may well be a better solution for this.
         */
        $this->partialMock(ConsumerClient::class, function ($mock) {
            $mock->shouldReceive('updateUser')
                ->once()
                ->andReturn(true);
        });

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
            'occupation_id' => 2,
            'enabled' => true,
            'channel_id' => 'danielhe4rt',
            'pronouns' => 'she-her',
            'effect_id' => 1,
            'color_id' => 1,
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
        $user = User::factory()->create();

        if ($payload) {
            Settings::factory()->create([
                'user_id' => $user->id,
                'channel_id' => $payload,
                'occupation_id' => Occupation::factory(),
                'color_id' => Color::factory(),
                'effect_id' => Effect::factory(),
            ]);
        }

        // Act
        $response = $this
            ->actingAs($user)
            ->get(route('auth.my-settings', ['channel_id' => $payload]));

        // Assert
        $response
            ->assertOk()
            ->assertJsonCount($count, 'data')
            ->assertJsonStructure([
                'data' => [
                    0 => [
                        'color',
                        'effect',
                        'occupation',
                    ],
                ],
            ]);
    }

    #[DataProvider('settingsByFieldDataProvider')]
    public function test_user_can_update_a_single_field_put(array $payload): void
    {
        // prepare
        $user = User::factory()->create();

        $payload['channel_id'] = 'global';

        $this->partialMock(ConsumerClient::class, function ($mock) {
            $mock->shouldReceive('updateUser')
                ->once()
                ->andReturn(true);
        });

        // act
        $response = $this
            ->actingAs($user)
            ->patchJson(route('auth.update-single-setting'), $payload);

        // assert
        $response->assertOk();

        $this->assertDatabaseHas(Settings::class, [
            'user_id' => $user->getKey(),
            ...$payload,
        ]);
    }

    public static function settingsByFieldDataProvider()
    {
        return [
            'update_color' => [
                'payload' => [
                    'color_id' => 2,
                ],
            ],
            'update_effect' => [
                'payload' => [
                    'effect_id' => 2,
                ],
            ],
            'update_occupation' => [
                'payload' => [
                    'occupation_id' => 2,
                ],
            ],
            'update_pronouns' => [
                'payload' => [
                    'pronouns' => 'she-her',
                ],
            ],
        ];
    }

    public static function settingsDataProvider()
    {
        return [
            'only_global' => [
                'payload' => null,
                'count' => 1,
            ],
            'with_channel' => [
                'payload' => 'danielhe4rt',
                'count' => 2,
            ],
        ];
    }
}
