<?php

namespace App\Domains\Shared\Exceptions;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DatabaseException extends ServiceException
{
    public function __construct(
        string $message = "Database error",
        int $code = Response::HTTP_CONFLICT,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}