<?php

declare(strict_types=1);

namespace DeviTools\Exceptions;

use DeviTools\Http\Status;

/**
 * Class ErrorValidation
 *
 * @package DeviTools\Exceptions
 */
class ErrorValidation extends ErrorGeneral
{
    /**
     * @var int
     */
    protected $statusCode = Status::CODE_400;

    /**
     * @var int
     */
    protected $defaultMessage = 'Invalid input';
}
