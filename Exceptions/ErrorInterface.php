<?php

namespace DeviTools\Exceptions;

/**
 * Interface ErrorInterface
 * @package DeviTools\Exceptions
 */
interface ErrorInterface
{
    /**
     * @return array
     */
    public function getDetails(): array;

    /**
     * @return int
     */
    public function getStatusCode(): int;
}
