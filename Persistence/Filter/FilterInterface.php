<?php

declare(strict_types=1);

namespace DeviTools\Persistence\Filter;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface Query
 *
 * @package DeviTools\Persistence\Filter
 */
interface FilterInterface
{
    /**
     * @param Builder $query
     * @param string $connector
     * @param string $value
     * @param string $column
     *
     * @return Builder
     */
    public function orWhere(Builder $query, string $connector, string $value, string $column): Builder;

    /**
     * @param Builder $query
     * @param string $connector
     * @param string $value
     * @param string $column
     *
     * @return Builder
     */
    public function where(Builder $query, string $connector, string $value, string $column): Builder;

    /**
     * @param Builder $query
     * @param string $connector
     * @param string $value
     * @param string $column
     *
     * @return Builder
     */
    public function query(Builder $query, string $connector, string $value, string $column): Builder;
}
