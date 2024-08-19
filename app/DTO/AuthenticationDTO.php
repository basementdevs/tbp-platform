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
        return new AuthenticationDTO(
            authorization: $authorization,
            user: $user,
        );
    }
}
