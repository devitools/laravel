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
    protected int $statusCode = Status::CODE_400;

    /**
     * @var string
     */
    protected string $defaultMessage = 'Invalid input';
}
