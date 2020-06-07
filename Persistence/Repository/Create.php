<?php

declare(strict_types=1);

namespace Devitools\Persistence\Repository;

use Devitools\Persistence\AbstractModel;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * Trait Create
 *
 * @package Devitools\Persistence\Repository
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
        if (!isset($data['id'])) {
            $data['id'] = Uuid::uuid1()->toString();
        }

        $data = $this->prepare($data['id'], $data, true);
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
