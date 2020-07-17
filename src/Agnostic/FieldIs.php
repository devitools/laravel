<?php

namespace Devitools\Agnostic;

use Devitools\Persistence\AbstractRepository;

/**
 * Trait FieldIs
 *
 * @package Devitools\Agnostic
 */
trait FieldIs
{
    /**
     * @return $this
     */
    protected function isBoolean(): self
    {
        $this->fields[$this->currentField]->type = 'boolean';
        $this->fields[$this->currentField]->cast = 'boolean';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isInput(): self
    {
        $this->fields[$this->currentField]->type = 'string';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isNumber(): self
    {
        $this->fields[$this->currentField]->type = 'number';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isPassword(): self
    {
        $this->fields[$this->currentField]->type = 'password';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isEmail(): self
    {
        $this->fields[$this->currentField]->type = 'email';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isText(): self
    {
        $this->fields[$this->currentField]->type = 'text';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isCheckbox(): self
    {
        return $this->isBoolean();
    }

    /**
     * @return $this
     */
    protected function isRadio(): self
    {
        $this->fields[$this->currentField]->type = 'options';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isSelect(): self
    {
        $this->fields[$this->currentField]->type = 'options';
        return $this;
    }

    /**
     * @param string $remote
     * @param string $exposed
     * @param string|null $ownerKey
     *
     * @return $this
     */
    protected function isSelectRemote(string $remote, string $exposed, string $ownerKey = null): self
    {
        $this->fields[$this->currentField]->type = 'string';
        $this->fields[$this->currentField]->manyToOne = (object)[
            'name' => $exposed,
            'remote' => $remote,
            'ownerKey' => $ownerKey ?? 'uuid',
        ];
        return $this;
    }

    /**
     * @return $this
     */
    protected function isSelectRemoteMultiple(): self
    {
        $this->fields[$this->currentField]->type = 'hasMany';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isToggle(): self
    {
        return $this->isBoolean();
    }

    /**
     * @return $this
     */
    protected function isDate(): self
    {
        $this->fields[$this->currentField]->type = 'date';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isDatetime(): self
    {
        $this->fields[$this->currentField]->type = 'datetime';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isInputPlan(): self
    {
        $this->fields[$this->currentField]->type = 'string';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isUrl(): self
    {
        $this->fields[$this->currentField]->type = 'url';
        return $this;
    }

    /**
     * @param string $remote
     * @param string $foreignKey
     * @param callable|string|null $callable
     * @param string|null $localKey
     *
     * @return $this
     */
    protected function isArray(string $remote, string $foreignKey, $callable = null, string $localKey = null): self
    {
        $this->fields[$this->currentField]->type = 'hasMany';
        $this->fields[$this->currentField]->hasMany = (object)[
            'name' => $this->currentField,
            'remote' => $remote,
            'foreignKey' => $foreignKey,
            'callable' => $callable,
            'localKey' => $localKey ?? $this->primaryKey,
        ];
        $this->fields[$this->currentField]->fill = false;
        return $this;
    }

    /**
     * @param string $foreignKey
     * @param string $repository
     * @param string|null $localKey
     *
     * @return $this
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
     * @return $this
     */
    protected function isTree(string $remote, string $foreignKey, $callable, string $localKey = null): self
    {
        $this->isArray($remote, $foreignKey, $callable, $localKey);
        return $this;
    }

    /**
     * @return $this
     */
    protected function isCurrency(): self
    {
        $this->fields[$this->currentField]->type = 'currency';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isImage(): self
    {
        $this->fields[$this->currentField]->type = 'image';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isFile(): self
    {
        $this->fields[$this->currentField]->type = 'file';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isFileSync(): self
    {
        $this->fields[$this->currentField]->type = 'file';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isInternationalPhone(): self
    {
        $this->fields[$this->currentField]->type = 'string';
        return $this;
    }

    /**
     * @return $this
     */
    protected function isJSON(): self
    {
        $this->fields[$this->currentField]->type = 'json';
        return $this;
    }
}
