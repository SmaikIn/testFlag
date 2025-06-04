<?php

namespace App\Domains\Shared\Exceptions;

use App\Domains\Shared\Responses\JsonErrorResponse;
use JetBrains\PhpStorm\Pure;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ServiceException extends RuntimeException
{
    #[Pure]
    public function __construct(string $message, int $code, Throwable $previous = null)
    {
        parent::__construct('Service exception '.$message, $code, $previous);
    }

    public function render(): JsonErrorResponse
    {
        return new JsonErrorResponse($this->message, status: $this->code);
    }
}
