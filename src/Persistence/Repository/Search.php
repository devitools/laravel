<?php

declare(strict_types=1);

namespace Devitools\Persistence\Repository;

use Devitools\Persistence\AbstractModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

use function is_array;

/**
 * Trait Search
 *
 * @package Devitools\Persistence\Repository
 * @property AbstractModel model
 */
trait Search
{
    /**
     * @param array $options
     * @param bool $trash
     *
     * @return array
     */
    public function search(array $options = [], $trash = false): array
    {
        $filters = $options['filters'] ?? [];
        $offset = (int)($options['offset'] ?? 0);
        $limit = (int)($options['limit'] ?? 25);
        $sorter = $this->model->parseSorter($options['sorter'] ?? null);

        return $this->find($filters, $sorter, $offset, $limit, $trash)->toArray();
    }

    /**
     * @param array $filters
     * @param array $sorter
     * @param int $offset
     * @param int $limit
     * @param false $trash
     *
     * @return Builder[]|Collection
     */
    public function find(array $filters, $sorter = [], $offset = 0, $limit = 25, $trash = false)
    {
        /** @var AbstractModel $query */
        $query = $this->where($filters, $trash);

        return $this->queryFind($query, $sorter, $offset, $limit);
    }

    /**
     * @param AbstractModel|Builder $query
     * @param array $sorter
     * @param int $offset
     * @param int $limit
     *
     * @return Builder[]|Collection
     */
    protected function queryFind($query, array $sorter = [], int $offset = 0, int $limit = 0)
    {
        $manyToOne = $this->model->manyToOne();
        foreach (array_keys($manyToOne) as $related) {
            /** @var Builder $query */
            $query = $query->with($related);
        }

        foreach ($sorter as $column => $direction) {
            $query = $query->orderBy($column, $direction);
        }

        if ($limit === 0) {
            return $query->get($this->model->columns());
        }

        return $query
            ->offset($offset)
            ->limit($limit)
            ->get($this->model->columns());
    }
}
