<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Persistence\AbstractModel;
use App\Persistence\ModelInterface;

/**
 * Trait Read
 *
 * @package App\Persistence\Repository
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
        foreach (array_keys($oneToMany) as $related) {
            /** @var Builder $query */
            $query = $query->with($related);
        }

        /** @var Collection $collection */
        return $query
            ->get($this->model->columns())
            ->first();
    }
}
