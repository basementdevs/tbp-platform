<?php

namespace App\Clients\Consumer\DTO;

use App\DTO\AuthorizationDTO;

readonly class UserTokenDTO
{
    public function __construct(
        public AuthorizationDTO $authDTO,
        public int $userId,
    ) {}

    public static function factory(AuthorizationDTO $authenticationDTO, int $userId): UserTokenDTO
    {
        return new UserTokenDTO(
            authDTO: $authenticationDTO,
            userId: $userId,
        );
    }
}
