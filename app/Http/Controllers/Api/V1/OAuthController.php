<?php

namespace App\Http\Controllers\Api\V1;

use App\Clients\Consumer\ConsumerClient;
use App\Clients\Consumer\DTO\UserTokenDTO;
use App\DTO\AuthenticationDTO;
use App\DTO\AuthorizationDTO;
use App\Http\Controllers\Controller;
use ChrisReedIO\Socialment\Exceptions\AbortedLoginException;
use ChrisReedIO\Socialment\Facades\Socialment;
use ChrisReedIO\Socialment\Models\ConnectedAccount;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    public function __construct(private readonly ConsumerClient $consumerClient) {}

    public function authenticateWithOAuth(string $provider)
    {
        $socialUser = Socialite::driver($provider)
            ->stateless()
            ->user();

        $response = $this->registerAndAuthenticate($provider, $socialUser);
        $this->consumerClient->sendUserToken(UserTokenDTO::factory(
            $response->authorization,
            $response->user->id
        ));

        return response()->json($response);
    }

    public function registerAndAuthenticate(string $provider, $socialUser): AuthenticationDTO
    {
        $tokenExpiration = $socialUser->expiresIn
            ? now()->addSeconds($socialUser->expiresIn)
            : now()->addDays((int) config('extension.user_token_ttl'));

        return \DB::transaction(function () use ($provider, $socialUser, $tokenExpiration) {
            // Create a user or log them in...
            $connectedAccount = ConnectedAccount::firstOrNew([
                'provider' => $provider,
                'provider_user_id' => $socialUser->getId(),
            ], [
                'name' => $socialUser->getName(),
                'nickname' => $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(),
                'token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken,
                'expires_at' => $tokenExpiration,
            ]);

            if (! $connectedAccount->exists) {
                // Check for an existing user with this email
                // Create a new user if one doesn't exist
                $user = Socialment::createUser($connectedAccount);

                if ($user === null) {
                    throw new AbortedLoginException('This account is not authorized to log in.');
                }

                // Associate the user and save this connected account
                $connectedAccount->user()->associate($user)->save();
            } else {
                // Update the connected account with the latest data
                $connectedAccount->update([
                    'name' => $socialUser->getName(),
                    'nickname' => $socialUser->getNickname(),
                    'email' => $socialUser->getEmail(),
                    'avatar' => $socialUser->getAvatar(),
                    'token' => $socialUser->token,
                    'refresh_token' => $socialUser->refreshToken,
                    'expires_at' => $tokenExpiration,
                ]);
            }
            // AccessToken
            $accessToken = $connectedAccount
                ->user
                ->createToken('authToken', ['*'], $tokenExpiration)
                ->plainTextToken;

            $user = $connectedAccount->user()->with(['settings.occupation', 'settings.color', 'settings.effect', 'accounts'])->first();

            return AuthenticationDTO::factory(
                AuthorizationDTO::factory($accessToken, $tokenExpiration),
                $user,
            );
        });
    }
}
