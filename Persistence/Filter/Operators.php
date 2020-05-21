<?php

declare(strict_types=1);

namespace App\Persistence\Filter;

use App\Persistence\Filter\Operators\FilterCurrency;
use App\Persistence\Filter\Operators\FilterEqual;
use App\Persistence\Filter\Operators\FilterIn;
use App\Persistence\Filter\Operators\FilterLike;
use App\Persistence\Filter\Operators\FilterNotEqual;
use App\Persistence\Filter\Operators\FilterNotIn;

/**
 * Class Operators
 *
 * @package App\Persistence\Filter
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
    public const NOT_EQUAL = 'neq';

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
    private static array $filters = [];

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
            static::NOT_EQUAL => FilterNotEqual::class,
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