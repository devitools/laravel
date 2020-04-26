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
    protected $statusCode = Status::CODE_401;

    /**
     * @var int
     */
    protected $defaultMessage = 'Invalid credentials';
}
