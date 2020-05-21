<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\Status;

/**
 * Class ErrorUserForbidden
 * @package App\Exceptions
 */
class ErrorUserForbidden extends ErrorGeneral
{
    /**
     * @var int
     */
    protected int $statusCode = Status::CODE_403;

    /**
     * @var string
     */
    protected string $defaultMessage = 'Invalid credentials';
}
