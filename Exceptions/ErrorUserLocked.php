<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\Status;

/**
 * Class ErrorUserLocked
 * @package App\Exceptions
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
