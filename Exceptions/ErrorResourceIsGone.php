<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\Status;

/**
 * Class ErrorResourceIsGone
 * @package App\Exceptions
 */
class ErrorResourceIsGone extends ErrorGeneral
{
    /**
     * @var int
     */
    protected int $statusCode = Status::CODE_410;

    /**
     * @var string
     */
    protected string $defaultMessage = 'Gone';
}
