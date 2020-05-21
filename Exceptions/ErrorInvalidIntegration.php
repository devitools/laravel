<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\Status;

/**
 * Class ErrorInvalidTabulationData
 * @package App\Exceptions
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
