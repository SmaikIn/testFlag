<?php

namespace App\Domains\User\ValueObject;

use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

final class Password
{
    /** @var string */
    private string $value;

    private function __construct(string $password)
    {
        $this->validate($password);
        $this->value = $password;
    }

    public static function create(string $password): self
    {
        return new self($password);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getHashValue(): string
    {
        return Hash::make($this->value);
    }

    public function equals(Password $other): bool
    {
        return $this->value === $other->getValue();
    }

    private function validate(string $password): void
    {
        // Минимальная и максимальная длина
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters long');
        }

        if (strlen($password) > 20) {
            throw new InvalidArgumentException('Password must be less than 20 characters');
        }

        // Дополнительные проверки безопасности
        if (!preg_match('/[A-Z]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one uppercase letter');
        }

        if (!preg_match('/[a-z]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one lowercase letter');
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one digit');
        }

        if (!preg_match('/[\W_]/', $password)) {
            throw new InvalidArgumentException('Password must contain at least one special character');
        }
    }

    public static function generate(int $length = 15): string
    {
        if ($length < 8 || $length > 255) {
            throw new InvalidArgumentException('Password length must be between 8 and 255 characters.');
        }

        $upperCaseLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowerCaseLetters = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialCharacters = '!@#$%^&*()_+-=[]{}|;:,.<>?';

        // Гарантируем наличие хотя бы одного символа каждого типа
        $password = [
            $upperCaseLetters[random_int(0, strlen($upperCaseLetters) - 1)],
            $lowerCaseLetters[random_int(0, strlen($lowerCaseLetters) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $specialCharacters[random_int(0, strlen($specialCharacters) - 1)]
        ];

        // Заполняем оставшуюся длину пароля случайными символами
        $allCharacters = $upperCaseLetters . $lowerCaseLetters . $numbers . $specialCharacters;

        for ($i = 4; $i < $length; $i++) {
            $password[] = $allCharacters[random_int(0, strlen($allCharacters) - 1)];
        }

        // Перемешиваем массив для случайного порядка символов
        shuffle($password);

        return implode('', $password);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
