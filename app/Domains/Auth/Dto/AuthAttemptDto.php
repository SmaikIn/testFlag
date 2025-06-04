<?php

declare(strict_types=1);

namespace App\Domains\Auth\Dto;



use App\Domains\User\ValueObject\Email;
use App\Domains\User\ValueObject\Password;

final readonly class AuthAttemptDto
{
    public function __construct(
        private Email $email,
        private Password $password,
    ) {
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }
}
