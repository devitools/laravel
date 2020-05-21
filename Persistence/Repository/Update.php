<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Persistence\AbstractModel;

/**
 * Trait Update
 *
 * @package App\Persistence\Repository
 */
trait Update
{
    /**
     * @param string $id
     * @param array $data
     *
     * @return string
     */
    public function update(string $id, array $data): ?string
    {
        /** @var AbstractModel $instance */
        $instance = $this->pull($id);
        if ($instance === null) {
            return null;
        }
        $data = $this->prepare($data['id'], $data, false);
        $instance->fill($data);
        $instance->save();
        return $instance->getPrimaryKeyValue();
    }
}