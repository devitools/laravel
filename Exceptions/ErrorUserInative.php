<?php

namespace DeviTools\Exceptions;

use DeviTools\Http\Status;

/**
 * Class ErrorUserInative
 * @package DeviTools\Exceptions
 */
class ErrorUserInative extends ErrorGeneral
{
    /**
     * @var int
     */
    protected $statusCode = Status::CODE_402;

    /**
     * @var int
     */
    protected $defaultMessage = 'Invalid credentials';
}
