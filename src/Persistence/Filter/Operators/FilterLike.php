<?php

declare(strict_types=1);

namespace Devitools\Persistence\Filter\Operators;

use Devitools\Persistence\Filter\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FilterLike
 *
 * @package Devitools\Persistence\Filter\Filters
 */
class FilterLike extends FilterAbstract
{
    /**
     * @param Builder $query
     * @param string $connector
     * @param string $value
     * @param string $column
     *
     * @return Builder
     */
    public function where(Builder $query, string $value, string $column, string $connector): Builder
    {
        return $query->where($column, 'like', "%{$value}%");
    }

    /**
     * @param Builder $query
     * @param string $connector
     * @param string $value
     * @param string $column
     *
     * @return Builder
     */
    public function orWhere(Builder $query, string $value, string $column, string $connector): Builder
    {
        return $query->orWhere($column, 'like', "%{$value}%");
    }
}
