<?php

declare(strict_types=1);

namespace Devitools\Persistence\Filter\Operators;

use Devitools\Persistence\Filter\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FilterIn
 *
 * @package Devitools\Persistence\Filter\Operators
 */
class FilterIn extends FilterAbstract
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
        $values = (array)explode(',', $value);
        return $query->whereIn($column, $values);
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
        $values = (array)explode(',', $value);
        return $query->orWhereIn($column, $values);
    }
}
