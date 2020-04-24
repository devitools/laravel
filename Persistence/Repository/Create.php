<?php

declare(strict_types=1);

namespace Simples\Persistence\Repository;

use Exception;
use Ramsey\Uuid\Uuid;
use Simples\Persistence\AbstractModel;

/**
 * Trait Create
 *
 * @package Simples\Persistence\Repository
 * @property AbstractModel model
 */
trait Create
{
    /**
     * @param array $data
     *
     * @return string
     * @throws Exception
     */
    public function create(array $data): ?string
    {
        $model = clone $this->model;

        $primaryKey = $model->exposedKey();
        if (!isset($data[$primaryKey])) {
            $data[$primaryKey] = Uuid::uuid1()->toString();
        }
        $model->fill($data);
        $model->save();
        return $model->getPrimaryKeyValue();
    }
}
