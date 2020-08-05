<?php

declare(strict_types=1);

namespace Devitools\Persistence\Repository;

use Devitools\Persistence\AbstractModel;
use Devitools\Persistence\ModelInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Read
 *
 * @package Devitools\Persistence\Repository
 * @property AbstractModel model
 */
trait Read
{
    /**
     * @param string $id
     * @param bool $trash
     *
     * @return ModelInterface
     */
    public function read(string $id, $trash = false): ?ModelInterface
    {
        $filters = $this->filterById($id);

        /** @var AbstractModel $query */
        $query = $this->where($filters, $trash);

        $manyToOne = $this->model->manyToOne();
        foreach (array_keys($manyToOne) as $related) {
            /** @var Builder $query */
            $query = $query->with($related);
        }

        $manyToMany = $this->model->manyToMany();
        foreach (array_keys($manyToMany) as $related) {
            /** @var Builder $query */
            $query = $query->with($related);
        }

        $oneToMany = $this->model->oneToMany();
        foreach ($oneToMany as $with => $related) {
            /** @var Builder $query */
            $query = $query->with($with);
            if (is_callable($related)) {
                continue;
            }
            if (!isset($related['with'])) {
                continue;
            }
            if (is_string($related['with'])) {
                $query = $query->with($related['with']);
            }
        }

        return $query
            ->get($this->model->columns())
            ->first();
    }
}
