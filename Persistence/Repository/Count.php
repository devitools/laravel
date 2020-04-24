<?php

declare(strict_types=1);

namespace Simples\Persistence\Repository;

use Illuminate\Database\Eloquent\Builder;
use Simples\Persistence\AbstractModel;

/**
 * Trait Count
 *
 * @package Simples\Persistence\Repository
 * @property AbstractModel model
 */
trait Count
{
    /**
     * @param array $filters
     * @param bool $trash
     *
     * @return int
     */
    public function count(array $filters, $trash = false): int
    {
        /** @var Builder $query */
        $query = $this->where($filters, $trash);

        return $query->count();
    }
}