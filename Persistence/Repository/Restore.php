<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Persistence\AbstractModel;

/**
 * Trait Restore
 *
 * @package App\Persistence\Repository
 */
trait Restore
{
    /**
     * @param string $id
     *
     * @return string
     */
    public function restore(string $id): ?string
    {
        /** @var AbstractModel $instance */
        $instance = $this->pull($id, true);
        if ($instance === null) {
            return null;
        }
        $instance->restore();
        return $instance->getValue('id');
    }
}