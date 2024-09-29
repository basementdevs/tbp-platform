<?php

namespace Tests\Feature\Http\Controllers\Api\V1;

use App\Clients\Consumer\ConsumerClient;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class OAuthControllerTest extends TestCase
{
    public function test_can_do_stuff()
    {
        $this->partialMock(ConsumerClient::class, function ($mock) {
            $mock->shouldReceive('sendUserToken')
                ->once()
                ->andReturn(true);
        });

        // Create a mock for the Socialite user
        $socialiteUserMock = \Mockery::mock(SocialiteUser::class);

        $socialiteUserMock->token = 123;

        // Mock the Socialite facade
        Socialite::shouldReceive('driver')
            ->once()
            ->with('twitch')
            ->andReturnSelf();

        Socialite::shouldReceive('stateless')
            ->once()
            ->andReturnSelf();

        Socialite::shouldReceive('user')
            ->once()
            ->andReturn($socialiteUserMock);

        // Now you can define expectations for the mock user if needed
        $socialiteUserMock->shouldReceive('getId')->andReturn('user-id');
        $socialiteUserMock->shouldReceive('getEmail')->andReturn('user@example.com');
        $socialiteUserMock->shouldReceive('getName')->andReturn('Test User');
        $socialiteUserMock->shouldReceive('getName')->andReturn('Test User');
        $socialiteUserMock->shouldReceive('getUsername')->andReturn('Test User');
        $socialiteUserMock->shouldReceive('getNickname')->andReturn('Test User');
        $socialiteUserMock->shouldReceive('getAvatar')->andReturn('Test User');
        $socialiteUserMock->shouldReceive('getToken')->andReturn('123');
        $socialiteUserMock->shouldReceive('getExpiresIn')->andReturn(123);

        // Make the request to the route
        $response = $this->postJson(route('oauth.handle', ['provider' => 'twitch', 'code' => 123]));

        // Assert that the response is OK (HTTP 200)
        $response->assertOk()
            ->assertJsonStructure([
                'authorization' => [
                    'access_token',
                    'token_type',
                    'expires_at',
                ],
                'user' => [
                    'settings' => [
                        0 => [
                            'id',
                            'pronouns',
                            'occupation',
                            'color',
                            'effect',
                        ],
                    ],
                ],
            ]);

    }
}
