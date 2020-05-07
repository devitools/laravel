<?php

declare(strict_types=1);

namespace DeviTools\Persistence\Filter\Operators;

use DeviTools\Persistence\Filter\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

use function Devitools\Helper\numberToCurrency;

/**
 * Class FilterCurrency
 *
 * @package DeviTools\Persistence\Filter\Operators
 */
class FilterCurrency extends FilterAbstract
{
    /**
     * @param Builder $query
     * @param string $connector
     * @param string $value
     * @param string $column
     *
     * @return Builder
     */
    public function where(Builder $query, string $connector, string $value, string $column): Builder
    {
        return $query->where($column, '=', numberToCurrency($value));
    }

    /**
     * @param Builder $query
     * @param string $connector
     * @param string $value
     * @param string $column
     *
     * @return Builder
     */
    public function orWhere(Builder $query, string $connector, string $value, string $column): Builder
    {
        return $query->orWhere($column, '=', numberToCurrency($value));
    }
}
