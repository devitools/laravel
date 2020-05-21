<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\Status;

/**
 * Class ErrorValidation
 *
 * @package App\Exceptions
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
