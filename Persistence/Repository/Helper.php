<?php

declare(strict_types=1);

namespace DeviTools\Persistence\Repository;

use DeviTools\Persistence\AbstractModel;

use function App\Helper\encodeUuid;
use function App\Helper\is_binary;

/**
 * Trait Helper
 *
 * @package DeviTools\Persistence\Repository
 * @property AbstractModel model
 */
trait Helper
{
    /**
     * @return array
     */
    public function fields(): array
    {
        $fillable = $this->model->getFillable();
        $relations = array_keys($this->model->manyToOne());
        return array_merge($fillable, $relations);
    }

    /**
     * @return string
     */
    public function referenceKey(): string
    {
        return $this->model->getKeyName();
    }

    /**
     * @return string
     */
    public function exposedKey(): string
    {
        return $this->model->exposedKey();
    }

    /**
     * @param string $id
     *
     * @return AbstractModel
     */
    public function findById($id): ?AbstractModel
    {
        if (!is_binary($id)) {
            $id = encodeUuid($id);
        }
        return $this->model->where($this->model->getKeyName(), $id)->first();
    }
}
