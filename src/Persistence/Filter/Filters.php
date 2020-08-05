<?php

declare(strict_types=1);

namespace Devitools\Persistence\Filter;

use Devitools\Persistence\Filter\Operators\FilterBetween;
use Devitools\Persistence\Filter\Operators\FilterCurrency;
use Devitools\Persistence\Filter\Operators\FilterEqual;
use Devitools\Persistence\Filter\Operators\FilterIn;
use Devitools\Persistence\Filter\Operators\FilterLike;
use Devitools\Persistence\Filter\Operators\FilterNotEqual;
use Devitools\Persistence\Filter\Operators\FilterNotIn;

/**
 * Class Filters
 *
 * @package Devitools\Persistence\Filter
 */
final class Filters
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
     * @var string
     */
    public const BETWEEN = 'between';

    /**
     * @var array
     */
    private static array $filters = [];

    /**
     * Filters constructor.
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
            static::BETWEEN => FilterBetween::class,
        ];

        if (!isset($operators[$operator])) {
            return null;
        }

        /** @var FilterInterface $reference */
        $reference = $operators[$operator];
        static::$filters[$operator] = $reference::get();

        return static::$filters[$operator];
    }
}
