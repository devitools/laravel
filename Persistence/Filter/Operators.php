<?php

declare(strict_types=1);

namespace DeviTools\Persistence\Filter;

use DeviTools\Persistence\Filter\Operators\FilterCurrency;
use DeviTools\Persistence\Filter\Operators\FilterEqual;
use DeviTools\Persistence\Filter\Operators\FilterLike;
use DeviTools\Persistence\Filter\Operators\FilterNotIn;

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
    public const SEPARATION_OPERATOR = '~.~';

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
    public const IN = 'in';

    /**
     * @var string
     */
    public const NIN = 'nin';

    /**
     * @var string
     */
    public const CURRENCY = 'currency';

    /**
     * @var array
     */
    private static $filters = [];

    /**
     * Operators constructor.
     */
    private function __construct()
    {
    }

    /**
     * @param string $operator
     *
     * @return FilterInterface|null
     */
    public static function filter(string $operator): ?FilterInterface
    {
        if (isset(static::$filters[$operator])) {
            return static::$filters[$operator];
        }

        $operators = [
            static::EQUAL => FilterEqual::class,
            static::LIKE => FilterLike::class,
            static::IN => FilterIn::class,
            static::NIN => FilterNotIn::class,
            static::CURRENCY => FilterCurrency::class,
        ];

        if (!isset($operators[$operator])) {
            return null;
        }

        /** @noinspection PhpUndefinedMethodInspection */
        static::$filters[$operator] = $operators[$operator]::build();

        return static::$filters[$operator];
    }
}