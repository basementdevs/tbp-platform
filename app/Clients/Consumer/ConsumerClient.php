<?php

namespace App\Clients\Consumer;

use App\Clients\Consumer\DTO\UserTokenDTO;
use App\Models\Settings\Settings;
use App\Models\User;
use ChrisReedIO\Socialment\Models\ConnectedAccount;
use GuzzleHttp\Client;

class ConsumerClient
{
    private Client $client;

    private string $baseVersionedUrl = '/api/v1';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.consumer-api.base_uri'),
            'headers' => [
                'Accept' => 'application/json',
                'X-Authorization' => config('services.consumer-api.secret'),
            ],
        ]);
    }

    public function updateUser(User $user, Settings $settings): void
    {
        $uri = $this->baseVersionedUrl.'/settings';

        /** @var ConnectedAccount $account */
        $account = $user->accounts->first(fn ($account) => $account->provider == 'twitch');

        $payload = [
            'user_id' => (int) $account->provider_user_id,
            'locale' => $settings->locale,
            'enabled' => $settings->enabled,
            'channel_id' => $settings->channel_id,
            'occupation' => [
                'name' => $settings->occupation->name,
                'translation_key' => $settings->occupation->translation_key,
                'slug' => $settings->occupation->slug,
            ],
            'effect' => [
                'name' => $settings->effect->name,
                'translation_key' => $settings->effect->translation_key,
                'slug' => $settings->effect->slug,
                'class_name' => $settings->effect->class_name,
                'hex' => $settings->effect->hex,
            ],
            'color' => [
                'name' => $settings->color->name,
                'translation_key' => $settings->color->translation_key,
                'slug' => $settings->color->slug,
                'hex' => $settings->color->hex,
            ],
            'pronouns' => $settings->pronouns,
            'timezone' => $settings->timezone,
            'username' => $account->nickname,
            'is_developer' => (bool) $user->is_admin,
        ];

        $response = $this->client->put($uri, ['json' => $payload]);

        if ($response->getStatusCode() !== 200) {
            throw new ConsumerClientException('Failed to update user settings');
        }
    }

    public function sendUserToken(UserTokenDTO $tokenDTO): void
    {
        $uri = $this->baseVersionedUrl.'/authenticate';

        $payload = [
            'user_id' => $tokenDTO->userId,
            'token' => $tokenDTO->authDTO->accessToken,
        ];

        $response = $this->client->post($uri, [
            'json' => $payload,
        ]);

        if ($response->getStatusCode() !== 201) {
            throw new ConsumerClientException('Failed to send user token');
        }
    }
}
