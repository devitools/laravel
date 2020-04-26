<?php

declare(strict_types=1);

namespace DeviTools\Exceptions;

use DeviTools\Http\Status;

/**
 * Class ErrorUserForbidden
 * @package DeviTools\Exceptions
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
