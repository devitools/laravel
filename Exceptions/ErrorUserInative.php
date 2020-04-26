<?php

declare(strict_types=1);

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
    protected int $statusCode = Status::CODE_402;

    /**
     * @var string
     */
    protected string $defaultMessage = 'Invalid credentials';
}
