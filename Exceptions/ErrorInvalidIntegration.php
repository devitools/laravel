<?php

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
    protected $statusCode = Status::CODE_400;

    /**
     * @var int
     */
    protected $defaultMessage = 'Invalid values to integration';
}
