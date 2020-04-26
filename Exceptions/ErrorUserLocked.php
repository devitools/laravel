<?php

namespace DeviTools\Exceptions;

use DeviTools\Http\Status;

/**
 * Class ErrorUserLocked
 * @package DeviTools\Exceptions
 */
class ErrorUserLocked extends ErrorGeneral
{
    /**
     * @var int
     */
    protected $statusCode = Status::CODE_429;

    /**
     * @var int
     */
    protected $defaultMessage = 'Invalid credentials';
}
