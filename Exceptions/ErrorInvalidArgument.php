<?php

declare(strict_types=1);

namespace DeviTools\Exceptions;

/**
 * Class ErrorInvalidArgument
 * @package DeviTools\Exceptions
 */
class ErrorInvalidArgument extends ErrorGeneral
{
    /**
     * @var string
     */
    protected string $defaultMessage = 'The argument is not valid';
}
