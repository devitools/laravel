<?php

declare(strict_types=1);

namespace App\Persistence\Filter;

/**
 * Class Connectors
 *
 * @package App\Persistence\Filter
 */
final class Connectors
{
    /**
     * @var string
     */
    public const AND = 'AND';

    /**
     * @var string
     */
    public const OR = 'OR';

    /**
     * Connectors constructor.
     */
    private function __construct()
    {
    }
}