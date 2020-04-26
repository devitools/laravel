<?php

declare(strict_types=1);

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
    protected int $statusCode = Status::CODE_429;

    /**
     * @var string
     */
    protected string $defaultMessage = 'Invalid credentials';
}
