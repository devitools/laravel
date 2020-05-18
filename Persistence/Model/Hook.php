<?php

declare(strict_types=1);

namespace DeviTools\Persistence\Model;

use App\Domains\Admin\Profile;
use DeviTools\Exceptions\ErrorInvalidArgument;
use DeviTools\Persistence\AbstractModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

use function Devitools\Helper\counter;
use function is_array;
use function PhpBrasil\Collection\pack;

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

        static::saved(static function (AbstractModel $model) {
            // parse many to many relationship
            $model->parseManyToMany();
            // parse one to many relationship
            $model->parseOneToMany();
        });
    }

    /**
     * @return void
     */
    protected function parseManyToMany(): void
    {
        $manyToMany = $this->manyToMany();
        foreach ($manyToMany as $alias => $column) {
            $items = $this->getFilled($alias);
            if (!is_array($items)) {
                return;
            }

            $ids = pack($items)
                ->map(function ($action) {
                    return static::encodeUuid($action[$this->exposedKey()]);
                })
                ->records();
            $this->{$alias}()->sync($ids);
        }
    }

    /**
     * @return void
     */
    protected function parseOneToMany(): void
    {
        $oneToMany = $this->oneToMany();
        foreach ($oneToMany as $alias => $parser) {
            $items = $this->getFilled($alias);
            if (!is_array($items)) {
                return;
            }

            /** @var HasMany $hasMany */
            $hasMany = $this->{$alias}();

            $localKey = $hasMany->getLocalKeyName();
            $foreignKey = $hasMany->getForeignKeyName();

            $hasMany->where($foreignKey, $this->getValue($localKey))->forceDelete();

            $values = pack($items)->map(function ($data) use ($parser, $foreignKey, $localKey) {
                $uuid = Uuid::uuid4();
                $value = [
                    'uuid' => $uuid->getBytes(),
                    'id' => $uuid->toString(),
                    'counter' => counter(),
                    $foreignKey => $this->getValue($localKey),
                ];
                return array_merge($value, $parser($data, $foreignKey, $localKey));
            });
            $hasMany->insert($values->records());
        }
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