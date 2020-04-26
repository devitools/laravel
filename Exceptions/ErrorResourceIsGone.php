<?php

declare(strict_types=1);

namespace DeviTools\Exceptions;

use DeviTools\Http\Status;

/**
 * Class ErrorResourceIsGone
 * @package DeviTools\Exceptions
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
