<?php

declare(strict_types=1);

namespace Simples\Report\Fragments;

use function count;

/**
 * Trait Where
 *
 * @package Simples\Report\Fragments
 */
trait Where
{
    /**
     * @return string
     */
    protected function where(): string
    {
        if (!count($this->where)) {
            return '';
        }
        return 'AND (' . implode(') AND (', $this->where) . ')';
    }
}