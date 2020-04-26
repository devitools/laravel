<?php

namespace DeviTools\Exceptions;

use DeviTools\Http\Status;

/**
 * Class ErrorUserForbidden
 * @package DeviTools\Exceptions
 */
class ErrorUserForbidden extends ErrorGeneral
{
    /**
     * @var int
     */
    protected $statusCode = Status::CODE_403;

    /**
     * @var int
     */
    protected $defaultMessage = 'Invalid credentials';
}
