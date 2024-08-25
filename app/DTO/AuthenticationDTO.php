<?php

namespace App\DTO;

use App\Models\User;

readonly class AuthenticationDTO
{
    public function __construct(
        public AuthorizationDTO $authorization,
        public User $user,
    ) {}

    public static function factory(AuthorizationDTO $authorization, User $user): AuthenticationDTO
    {
        // TODO: remove after releasing the next version. this is a workaround to not break the actual implementation
        // of settings feature
        $user->settings = $user->settings->filter(fn ($settings) => $settings->channel_id = 'global')->first();

        return new AuthenticationDTO(
            authorization: $authorization,
            user: $user,
        );
    }
}
