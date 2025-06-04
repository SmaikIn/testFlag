<?php

declare(strict_types=1);

namespace App\Domains\Auth\Dto;

use Carbon\Carbon;
use Ramsey\Uuid\UuidInterface;

final readonly class PayloadJWTDto
{
    public function __construct(
        private int $userId,
        private Carbon $expires,
    ) {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getExpires(): Carbon
    {
        return $this->expires;
    }
}