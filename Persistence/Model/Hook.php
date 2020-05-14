<?php

declare(strict_types=1);

namespace DeviTools\Persistence\Model;

use DeviTools\Exceptions\ErrorInvalidArgument;
use DeviTools\Persistence\AbstractModel;
use Ramsey\Uuid\Uuid;

use function DeviTools\Helper\numberToCurrency;
use function is_array;

/**
 * Trait Configure
 *
 * @package DeviTools\Persistence\Model
 */
trait Hook
{
    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::configure();

        static::creating(static function (AbstractModel $model) {
            // generate counter
            $model->counter();
        });

        static::saving(static function (AbstractModel $model) {
            // parse many to one relationship
            $model->parseManyToOne();
            // validate the values
            $model->validate();
        });
    }

    /**
     * @return void
     * @throws ErrorInvalidArgument
     */
    protected function parseManyToOne(): void
    {
        $manyToOne = $this->manyToOne();
        foreach ($manyToOne as $alias => $column) {
            $filled = $this->getFilled($alias);
            if ($filled === __UNDEFINED__) {
                continue;
            }
            if ($filled === null) {
                $this->setValue($column, null);
                continue;
            }
            if (!is_array($filled)) {
                continue;
            }
            $this->parseManyToOneArray($column, $filled);
        }
    }

    /**
     * @param string $column
     * @param array $filled
     *
     * @return void
     * @throws ErrorInvalidArgument
     */
    private function parseManyToOneArray(string $column, array $filled): void
    {
        if (!isset($filled[$this->exposedKey()])) {
            throw new ErrorInvalidArgument(["{$column}.{$this->exposedKey()}" => 'required']);
        }
        $id = $filled[$this->exposedKey()];
        $value = Uuid::fromString($id)->getBytes();
        $this->setValue($column, $value);
    }
}