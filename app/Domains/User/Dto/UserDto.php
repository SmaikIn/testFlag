<?php

declare(strict_types=1);

namespace App\Domains\User\Dto;


use App\Domains\User\ValueObject\Email;
use App\Domains\User\ValueObject\Password;
use Carbon\Carbon;

final class UserDto
{
    public function __construct(
        private ?int $id,
        private string $name,
        private Email $email,
        private ?Password $password,
        private ?Carbon $createdAt,
        private ?Carbon $updatedAt,

    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    public function getPassword(): ?Password
    {
        return $this->password;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function setPassword(Password $password): void
    {
        $this->password = $password;
    }

    public function setCreatedAt(Carbon $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(Carbon $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

}