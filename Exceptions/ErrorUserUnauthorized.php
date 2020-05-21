<?php

namespace App\Exceptions;

use App\Http\Status;

/**
 * Class ErrorUserUnauthorized
 * @package App\Exceptions
 */
class ErrorUserUnauthorized extends ErrorGeneral
{
    /**
     * @var int
     */
    protected int $statusCode = Status::CODE_401;

    /**
     * @var string
     */
    protected string $defaultMessage = 'Invalid credentials';
}
