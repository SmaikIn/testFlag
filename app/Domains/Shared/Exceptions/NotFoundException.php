<?php

namespace App\Domains\Shared\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class NotFoundException extends ServiceException
{
    public function __construct(
        string $message,
        int $code = Response::HTTP_NOT_FOUND,
        Throwable $previous = null
    ) {
        $this->message = $message . ' Not Found';
        parent::__construct($message, $code, $previous);
    }
}