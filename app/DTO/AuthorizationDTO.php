<?php

namespace App\DTO;

use Carbon\Carbon;

readonly class AuthorizationDTO implements \JsonSerializable
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

    public function jsonSerialize(): array
    {
        return [
            'access_token' => $this->accessToken,
            'token_type' => $this->token,
            'expires_at' => $this->expiresAt->toIso8601String(),
        ];
    }
}
