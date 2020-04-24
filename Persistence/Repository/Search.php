<?php

declare(strict_types=1);

namespace Simples\Persistence\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Simples\Persistence\AbstractModel;

use function is_array;

/**
 * Trait Search
 *
 * @package Simples\Persistence\Repository
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
        $offset = $options['offset'] ?? 0;
        $limit = $options['limit'] ?? 25;
        $sorter = $options['sorter'] ?? null;

        if (!is_array($sorter)) {
            $sorter = $this->model->sorter();
        }

        return $this->find($filters, $sorter, $offset, $limit, $trash)->toArray();
    }

    /**
     * @param array $filters
     * @param array $sorter
     * @param int $offset
     * @param int $limit
     * @param bool $trash
     *
     * @return AbstractModel[]|Builder[]|Collection
     */
    public function find(array $filters, $sorter = [], $offset = 0, $limit = 25, $trash = false)
    {
        /** @var AbstractModel $query */
        $query = $this->where($filters, $trash);

        $manyToOne = $this->model->manyToOne();
        foreach (array_keys($manyToOne) as $related) {
            /** @var Builder $query */
            $query = $query->with($related);
        }

        foreach ($sorter as $column => $direction) {
            $query = $query->orderBy($column, $direction);
        }

        return $query
            ->offset($offset)
            ->limit($limit)
            ->get($this->model->columns());
    }
}