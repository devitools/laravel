<?php

declare(strict_types=1);

namespace DeviTools\Exceptions;

/**
 * Class ErrorRuntime
 * @package DeviTools\Exceptions
 */
class ErrorRuntime extends ErrorGeneral
{
    /**
     * @var string
     */
    protected string $defaultMessage = 'Unknown error';
}
