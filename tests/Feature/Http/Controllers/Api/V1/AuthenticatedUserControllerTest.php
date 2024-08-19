<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Clients\Consumer\ConsumerClient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticatedUserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stu
    }

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
        $this->partialMock(ConsumerClient::class, function ($mock) use ($user) {
            $mock->shouldReceive('updateUser')
                ->once()
                ->with($user)
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
            'user_id' => $user->id,
            'occupation_id' => 2,
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
}
