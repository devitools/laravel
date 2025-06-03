<?php

declare(strict_types=1);

namespace Devitools\Agnostic;

use Devitools\Persistence\AbstractRepository;
use RuntimeException;

use function PhpBrasil\Collection\pack;

/**
 * Trait FieldIs
 *
 * @package Devitools\Agnostic
 */
trait FieldIs
{
    /**
     * @return Schema|FieldIs
     */
    protected function isBoolean(): self
    {
        $this->type('boolean');
        $this->castAs('boolean');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isInput(): self
    {
        $this->type('string');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isNumber(): self
    {
        $this->type('number');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isPassword(): self
    {
        $this->type('password');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isEmail(): self
    {
        $this->type('email');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isText(): self
    {
        $this->type('text');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isCheckbox(): self
    {
        return $this->isBoolean();
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isRadio(): self
    {
        $this->type('options');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isSelect(): self
    {
        $this->type('options');
        return $this;
    }

    /**
     * @param string $remote
     * @param string $exposed
     * @param string|null $ownerKey
     *
     * @return FieldIs|Schema
     */
    protected function isSelectRemote(string $remote, string $exposed, string $ownerKey = null): self
    {
        if (method_exists($this, $exposed)) {
            throw new RuntimeException('The exposed "' . $exposed . '" is not available');
        }
        $this->type('string');
        $this->fields[$this->currentField]->manyToOne = (object)[
            'name' => $exposed,
            'remote' => $remote,
            'ownerKey' => $ownerKey ?? __BINARY_KEY__,
            'with' => [],
        ];
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isSelectRemoteMultiple(): self
    {
        $this->type('hasMany');
        return $this;
    }

    /**
     * @param string $instruction
     *
     * @return Schema|FieldIs
     */
    protected function isCalculated(string $instruction): self
    {
        $this->fields[$this->currentField]->calculated = $instruction;
        return $this;
    }

    /**
     * @param string $exposed
     *
     * @return Schema|null
     */
    public function remote(string $exposed): ?Schema
    {
        $collection = $this->$exposed();
        if ($collection) {
            return $collection->first();
        }
        return null;
    }

    /**
     * @param string $exposed
     * @param string $name
     * @param mixed|null $fallback
     *
     * @return mixed|null
     */
    public function remoteValue(string $exposed, string $name, mixed $fallback = null)
    {
        $model = $this->remote($exposed);
        if (!$model) {
            return $fallback;
        }
        return $model->getValue($name);
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isToggle(): self
    {
        return $this->isBoolean();
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isDate(): self
    {
        $this->type('date');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isDatetime(): self
    {
        $this->type('datetime');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isInputPlan(): self
    {
        $this->type('string');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isUrl(): self
    {
        $this->type('url');
        return $this;
    }

    /**
     * @param string $remote
     * @param string $foreignKey
     * @param null $setup
     * @param string|null $localKey
     *
     * @return Schema|FieldIs
     */
    protected function isArray(string $remote, string $foreignKey, $setup = null, string $localKey = null): self
    {
        $this->type('hasMany');
        $this->fields[$this->currentField]->hasMany = (object)[
            'name' => $this->currentField,
            'remote' => $remote,
            'foreignKey' => $foreignKey,
            'setup' => $setup,
            'localKey' => $localKey ?? $this->primaryKey,
            'with' => [],
        ];
        $this->fields[$this->currentField]->fill = false;
        return $this;
    }

    /**
     * @param string $repository
     * @param string $foreignKey
     * @param string|null $localKey
     *
     * @return Schema|FieldIs
     */
    protected function isBuiltin(string $repository, string $foreignKey, string $localKey = null): self
    {
        /** @var AbstractRepository $repository */
        $remote = $repository::instance()->getPrototype();
        $this->isArray($remote, $foreignKey, $repository, $localKey);
        return $this;
    }

    /**
     * @param string $remote
     * @param string $foreignKey
     * @param string|callable $callable
     * @param string|null $localKey
     *
     * @return Schema|FieldIs
     */
    protected function isTree(string $remote, string $foreignKey, $callable, string $localKey = null): self
    {
        $this->isArray($remote, $foreignKey, $callable, $localKey);
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isCurrency(): self
    {
        $this->type('currency');
        $this->currency(true);
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isImage(): self
    {
        $this->type('image');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isFile(): self
    {
        $this->type('file');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isFileSync(): self
    {
        $this->type('file');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isInternationalPhone(): self
    {
        $this->type('string');
        return $this;
    }

    /**
     * @return Schema|FieldIs
     */
    protected function isJSON(): self
    {
        $this->type('json');
        $this->castAs('json');
        return $this;
    }

    /**
     * @param array $properties
     *
     * @return Schema|FieldIs
     */
    protected function withNested(array $properties): self
    {
        if (isset($this->fields[$this->currentField]->manyToOne)) {
            $name = $this->fields[$this->currentField]->manyToOne->name;
            $with = pack($properties)
                ->map(static function ($property) use ($name) {
                    return "{$name}.{$property}";
                })
                ->records();
            $this->fields[$this->currentField]->manyToOne->with = $with;
        }

        if (isset($this->fields[$this->currentField]->hasMany)) {
            $name = $this->fields[$this->currentField]->hasMany->name;
            $with = pack($properties)
                ->map(static function ($property) use ($name) {
                    return "{$name}.{$property}";
                })
                ->records();
            $this->fields[$this->currentField]->hasMany->with = $with;
        }

        return $this;
    }
}
