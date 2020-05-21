<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * Class ErrorRuntime
 * @package App\Exceptions
 */
class ErrorRuntime extends ErrorGeneral
{
    /**
     * @var string
     */
    protected string $defaultMessage = 'Unknown error';
}
