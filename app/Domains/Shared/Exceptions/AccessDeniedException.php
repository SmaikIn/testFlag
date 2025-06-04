<?php

namespace App\Domains\Shared\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class AccessDeniedException extends ServiceException
{
    public function __construct(
        string $message = "You don't have access",
        int $code = Response::HTTP_FORBIDDEN,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}