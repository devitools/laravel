<?php

namespace DeviTools\Exceptions;

use DeviTools\Http\Status;

/**
 * Class ErrorInvalidArgument
 * @package DeviTools\Exceptions
 */
class ErrorInvalidArgument extends ErrorGeneral
{
    /**
     * @var int
     */
    protected $statusCode = Status::CODE_500;

    /**
     * @var int
     */
    protected $defaultMessage = 'The argument is not valid';
}
