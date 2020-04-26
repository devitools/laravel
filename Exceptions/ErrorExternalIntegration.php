<?php

declare(strict_types=1);

namespace DeviTools\Exceptions;

/**
 * Class ErrorExternalIntegration
 * @package DeviTools\Exceptions
 */
class ErrorExternalIntegration extends ErrorGeneral
{
    /**
     * ErrorExternalIntegration constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct([], $message);
    }
}
