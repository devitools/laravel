<?php

declare(strict_types=1);

namespace DeviTools\Exceptions;

use Exception;
use DeviTools\Http\Status;

use function DeviTools\Helper\error;
use function is_string;

/**
 * Class ErrorGeneral
 *
 * @package DeviTools\Exceptions
 */
abstract class ErrorGeneral extends Exception implements ErrorInterface
{
    /**
     * @var int
     */
    protected int $statusCode = Status::CODE_500;

    /**
     * @var array
     */
    protected array $details = [];

    /**
     * @var string
     */
    protected string $defaultMessage = 'Server error';

    /**
     * ErrorValidation constructor.
     *
     * @param array $details
     * @param string|null $message
     * @param int|null $code
     * @param Exception|null $previous
     */
    public function __construct(
        array $details,
        string $message = null,
        ?int $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message ?: $this->defaultMessage, $code, $previous);

        $this->details = $this->parseDetails($details);
    }

    /**
     * @param array $details
     *
     * @return array
     */
    protected function parseDetails(array $details): array
    {
        foreach ($details as $field => &$value) {
            if (!is_string($value)) {
                continue;
            }
            $value = error($field, $value, null);
        }
        return $details;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
