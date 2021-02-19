<?php

declare(strict_types=1);

namespace Devitools\Agnostic;

use Devitools\Persistence\AbstractModel;
use Devitools\Units\Common\UserSession;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Schema
 *
 * @package Devitools\Agnostic
 */
abstract class Schema extends AbstractModel
{
    /**
     * @trait
     */
    use UserSession;
    use Fields;
    use FieldIs;
    use Relation;
    use Hooks;
    use Events;
    use Validation;

    /**
     * @var string
     */
    public const PRIMARY_KEY = __BINARY_KEY__;

    /**
     * @var array
     */
    protected array $currencies = [];

    /**
     * The resource associated with the schema.
     *
     * @return string
     */
    abstract public static function resource(): string;

    /**
     * The resource identifier of the schema
     *
     * @return array
     */
    public static function identifier(): array
    {
        return [static::resource(), static::PRIMARY_KEY];
    }

    /**
     * Build the schema fields and actions.
     *
     * @return void
     */
    abstract public function construct(): void;

    /**
     * Model constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->schema();
    }

    /**
     * @return $this
     */
    public function schema(): self
    {
        $this->construct();
        $this->table = $this::resource();

        $this->primaryKey = static::PRIMARY_KEY;

        $fields = $this->getFields();
        foreach ($fields as $key => $field) {
            $this->configureField($key, $field);
        }
        return $this;
    }

    /**
     * @param string $key
     * @param object $field
     */
    private function configureField(string $key, object $field): void
    {
        if ($field->fill) {
            $this->fillable[] = $key;
        }

        if ($field->hidden) {
            $this->hidden[] = $key;
        }

        if ($field->unique) {
            $this->uniques[] = $key;
        }

        if ($field->currency) {
            $this->currencies[] = $key;
        }

        if ($field->cast) {
            $this->casts[$key] = $field->cast;
        }

        if (count($field->rules)) {
            $this->rules[$key] = $field->rules;
        }

        if (is_array($field->avoid)) {
            $this->avoids[$key] = $field->avoid;
        }

        if (isset($field->manyToOne)) {
            $this->addManyToOne(
                $field->manyToOne->name,
                $field->manyToOne->remote,
                $key,
                $field->manyToOne->ownerKey
            );
        }

        if (isset($field->hasMany)) {
            $this->addOneToMany(
                $field->hasMany->name,
                $field->hasMany->remote,
                $field->hasMany->foreignKey,
                $field->hasMany->callable,
                $field->hasMany->localKey,
            );
        }
    }

    /**
     * @param bool $excludeDeleted
     *
     * @return Builder
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function newQuery($excludeDeleted = true)
    {
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        $query = parent::newQuery($excludeDeleted);

        if (!$this->hasHook('query:default')) {
            return $query;
        }
        return $this->triggerHook('query:default', [$query]);
    }

    /**
     * @return array
     */
    public function currencies(): array
    {
        return $this->currencies;
    }
}
