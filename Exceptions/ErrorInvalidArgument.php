<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * Class ErrorInvalidArgument
 * @package App\Exceptions
 */
class ErrorInvalidArgument extends ErrorGeneral
{
    /**
     * @var string
     */
    protected string $defaultMessage = 'The argument is not valid';
}
