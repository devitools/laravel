<?php

declare(strict_types=1);

namespace Simples\Report\Where;

/**
 * Trait WhereLike
 *
 * @package Simples\Report\Where
 * @property array $where
 */
trait WhereLike
{
    /**
     * @param array $filters
     * @param string $column
     * @param string $property
     *
     * @return $this
     */
    protected function addWhereLike(array &$filters, string $column, string $property = ''): self
    {
        if (!$property) {
            $property = $column;
        }
        $value = $filters[$property] ?? null;
        if (!$value) {
            return $this;
        }
        $filters[$property] = "%{$filters[$property]}%";
        $this->where[] = "{$column} LIKE :{$property}";
        return $this;
    }
}