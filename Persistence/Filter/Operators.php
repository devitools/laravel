<?php

declare(strict_types=1);

namespace DeviTools\Persistence\Filter;

/**
 * Class Operators
 *
 * @package DeviTools\Persistence\Filter
 */
final class Operators
{
    /**
     * @var string
     */
    public const SEPARATION_OPERATOR = '.~.';

    /**
     * @var string
     */
    public const EQUAL = 'eq';

    /**
     * @var string
     */
    public const LIKE = 'like';

    /**
     * @var string
     */
    public const CURRENCY = 'currency';

    /**
     * Operators constructor.
     */
    private function __construct()
    {
    }

    /**
     * @param string $operator
     *
     * @return string|null
     */
    public static function sign(string $operator): ?string
    {
        $signs = [
            static::EQUAL => '=',
            static::LIKE => 'like',
            static::CURRENCY => 'currency',
        ];
        return $signs[$operator] ?? null;
    }
}