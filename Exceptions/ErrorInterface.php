<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * Interface ErrorInterface
 * @package App\Exceptions
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
