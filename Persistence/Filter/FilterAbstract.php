<?php

declare(strict_types=1);

namespace Devitools\Persistence\Filter;

use Illuminate\Database\Eloquent\Builder;

use function Devitools\Helper\is_dot;

/**
 * Class FilterAbstract
 *
 * @package Devitools\Persistence\Filter
 */
abstract class FilterAbstract implements FilterInterface
{
    /**
     * @return self
     */
    final public static function build(): self
    {
        return new static();
    }

    /**
     * @param Builder $query
     * @param string $connector
     * @param string $value
     * @param string $column
     *
     * @return Builder
     */
    final public function query(Builder $query, string $connector, string $value, string $column): Builder
    {
        if (is_dot($column)) {
            return $this->queryBelongsTo($query, $connector, $value, $column);
        }

        if ($connector === Connectors::OR) {
            return $this->orWhere($query, $connector, $value, $column);
        }

        return $this->where($query, $connector, $value, $column);
    }

    /**
     * @param Builder $query
     * @param string $connector
     * @param string $value
     * @param string $column
     *
     * @return Builder
     */
    private function queryBelongsTo(Builder $query, string $connector, string $value, string $column): Builder
    {
        [$relation, $field] = (array)explode('.', $column);

        $callback = function (Builder $query) use ($connector, $value, $field) {
            $this->where($query, $connector, $value, $field);
        };

        if ($connector === Connectors::OR) {
            return $query->orWhereHas($relation, $callback);
        }
        return $query->whereHas($relation, $callback);
    }
}