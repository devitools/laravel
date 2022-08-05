<?php

declare(strict_types=1);

namespace Devitools\Agnostic;

/**
 * Trait Validation
 *
 * @package Devitools\Agnostic
 */
trait Validation
{
    /**
     * @param string $rule
     * @param array $parameters
     *
     * @return Schema|Validation
     */
    protected function validationAdd(string $rule, array $parameters = []): self
    {
        if (count($parameters)) {
            $details = implode(',', $parameters);
            $rule = "{$rule}:{$details}";
        }
        $this->fields[$this->currentField]->rules[] = $rule;
        return $this;
    }

    /**
     * @param string $rule
     *
     * @return Validation|Schema
     */
    protected function validationRemove(string $rule): self
    {
        if (($key = array_search('required', $this->fields[$this->currentField]->rules, true)) !== false) {
            unset($this->fields[$this->currentField]->rules[$key]);
        }
        return $this;
    }

    /**
     * @param $min
     *
     * @return Validation|Schema
     */
    protected function validationMin($min): self
    {
        return $this->validationAdd('min', [$min]);
    }

    /**
     * @param $max
     *
     * @return Validation|Schema
     */
    protected function validationMax($max): self
    {
        return $this->validationAdd('max', [$max]);
    }

    /**
     * @return Validation|Schema
     */
    protected function validationEmail(): self
    {
        return $this->validationAdd('email');
    }

    /**
     * @return Validation|Schema
     */
    protected function validationRequired(): self
    {
        return $this->validationAdd('required');
    }

    /**
     * @return Validation|Schema
     */
    protected function validationString(): self
    {
        return $this->validationAdd('string');
    }

    /**
     * @return Validation|Schema
     */
    protected function validationSometimes(): self
    {
        return $this->validationAdd('sometimes');
    }

    /**
     *
     * @return Validation|Schema
     */
    protected function validationNullable(): self
    {
        return $this->validationAdd('nullable');
    }

    /**
     * @param string $regex
     *
     * @return Validation|Schema
     */
    protected function validationRegex(string $regex): self
    {
        return $this->validationAdd('regex', [$regex]);
    }

    /**
     * @param array $options
     *
     * @return Validation|Schema
     */
    protected function validationIn(array $options): self
    {
        return $this->validationAdd('in', $options);
    }

}
