<?php

declare(strict_types=1);

namespace App\Domains\Auth\Events;

use App\Domains\User\Dto\UserDto;
use App\Shared\ValueObjects\Email;
use Illuminate\Foundation\Events\Dispatchable;

class FindUserByEmailEvent
{
    use Dispatchable;

    public function __construct(
        public readonly Email $email,
        public ?UserDto $userDto = null,

    ) {
    }

    public function getUserDto(): ?UserDto
    {
        return $this->userDto;
    }

    public function setUserDto(?UserDto $userDto): void
    {
        $this->userDto = $userDto;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }


}
