<?php

declare(strict_types=1);

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Dto\AuthAttemptDto;
use App\Domains\Auth\Dto\JWTDto;
use App\Domains\Auth\Dto\PayloadJWTDto;
use App\Domains\Auth\Exceptions\ErrorWhileTokenParsingException;
use Carbon\Carbon;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use Throwable;

final readonly class AuthService
{
    public function __construct(
        private JWTGuard $guard,

    ) {
    }

    /**
     * @param  AuthAttemptDto  $dto
     * @return JWTDto|null
     */
    public function attempt(AuthAttemptDto $dto): ?JWTDto
    {
        $token = $this->guard->attempt([
            'email' => $dto->getEmail()->getValue(),
            'password' => $dto->getPassword()->getValue()
        ]);

        if (!$token) {
            return null;
        }


        return $this->_getJWTDtoFromToken($token);
    }

    public function refresh(): ?JWTDto
    {
        try {
            $token = $this->guard->refresh();
        } catch (Throwable) {
            return null;
        }

        return $this->_getJWTDtoFromToken($token);
    }

    public function logout(): void
    {
        $this->guard->logout();
    }


    /**
     * @param  string  $token
     * @return JWTDto
     * @throws ErrorWhileTokenParsingException
     */
    private function _getJWTDtoFromToken(string $token): JWTDto
    {
        $payload = $this->_parsePayloadFromToken($token);


        return new JWTDto(
            $token,
            'bearer',
            $payload,
        );
    }

    /**
     * @param  string  $token
     * @return PayloadJWTDto
     * @throws ErrorWhileTokenParsingException
     */
    private function _parsePayloadFromToken(string $token): PayloadJWTDto
    {
        try {
            $payload = json_decode(base64_decode(explode('.', $token)[1]));
        } catch (Throwable $throwable) {
            throw new ErrorWhileTokenParsingException($throwable);
        }

        return new PayloadJWTDto(
            $payload->sub,
            Carbon::parse($payload->exp),
        );
    }

}
