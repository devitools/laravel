<?php

declare(strict_types=1);

namespace App\Report\Fragments;

use function count;

/**
 * Trait Where
 *
 * @package App\Report\Fragments
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