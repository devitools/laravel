<?php

namespace DeviTools\Exceptions;

use DeviTools\Http\Status;

/**
 * Class ErrorUserUnauthorized
 * @package DeviTools\Exceptions
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
