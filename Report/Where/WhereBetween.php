<?php

declare(strict_types=1);

namespace DeviTools\Report\Where;

/**
 * Trait WhereBetween
 *
 * @package DeviTools\Report\Where
 * @property array $where
 */
trait WhereBetween
{
    /**
     * @param array $filters
     * @param string $column
     * @param string $begin
     * @param string $end
     *
     * @return $this
     */
    protected function addWhereBetween(
        array $filters,
        string $column,
        string $begin = 'begin',
        string $end = 'end'
    ): self {
        $start = $filters[$begin] ?? null;
        $finish = $filters[$end] ?? null;

        if ($start && $finish) {
            $this->where[] = "{$column} BETWEEN :{$begin} AND :{$end}";
            return $this;
        }

        if ($start) {
            $this->where[] = "{$column} >= :{$begin}";
            return $this;
        }

        if ($finish) {
            $this->where[] = "{$column} >= :{$end}";
        }
        return $this;
    }
}