<?php

namespace DeviTools\Exceptions;

use DeviTools\Http\Status;

/**
 * Class ErrorRuntime
 * @package DeviTools\Exceptions
 */
class ErrorRuntime extends ErrorGeneral
{
    /**
     * @var int
     */
    protected $statusCode = Status::CODE_500;

    /**
     * @var int
     */
    protected $defaultMessage = 'Unknown error';
}
