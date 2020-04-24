<?php

declare(strict_types=1);

namespace DeviTools\Report\Fragments;

use function count;

/**
 * Trait Where
 *
 * @package DeviTools\Report\Fragments
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