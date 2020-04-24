<?php

declare(strict_types=1);

namespace Simples\Persistence\Repository;

use Simples\Persistence\AbstractModel;

/**
 * Trait Update
 *
 * @package Simples\Persistence\Repository
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
        $instance->fill($data)->save();
        return $instance->getValue('id');
    }
}