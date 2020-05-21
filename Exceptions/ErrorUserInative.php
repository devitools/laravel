<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\Status;

/**
 * Class ErrorUserInative
 * @package App\Exceptions
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
