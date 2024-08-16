<?php

namespace App\DTO;

use Carbon\Carbon;

readonly class AuthorizationDTO
{
    public function __construct(
        public string $accessToken,
        public Carbon $expiresAt,
        public string $token = 'Bearer',
    ) {}

    public static function factory($accessToken, $expiresAt): AuthorizationDTO
    {
        return new AuthorizationDTO(
            accessToken: $accessToken,
            expiresAt: $expiresAt,
        );
    }
}
