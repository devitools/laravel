<?php

declare(strict_types=1);

namespace Devitools\Persistence\Repository;

use Illuminate\Database\Eloquent\Builder;
use Devitools\Persistence\AbstractModel;

/**
 * Trait Count
 *
 * @package Devitools\Persistence\Repository
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