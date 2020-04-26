<?php

declare(strict_types=1);

namespace DeviTools\Exceptions;

use DeviTools\Http\Status;

/**
 * Class ErrorInvalidTabulationData
 * @package DeviTools\Exceptions
 */
class ErrorInvalidIntegration extends ErrorGeneral
{
    /**
     * @var int
     */
    protected int $statusCode = Status::CODE_400;

    /**
     * @var string
     */
    protected string $defaultMessage = 'Invalid values to integration';
}
