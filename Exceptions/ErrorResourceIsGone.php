<?php

namespace DeviTools\Exceptions;

use DeviTools\Http\Status;

/**
 * Class ErrorResourceIsGone
 * @package DeviTools\Exceptions
 */
class ErrorResourceIsGone extends ErrorGeneral
{
    /**
     * @var int
     */
    protected $statusCode = Status::CODE_410;

    /**
     * @var int
     */
    protected $defaultMessage = 'Gone';
}
