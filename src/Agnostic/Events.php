<?php

declare(strict_types=1);

namespace Devitools\Agnostic;

use Devitools\Exceptions\ErrorRuntime;

/**
 * Trait Events
 *
 * @package Devitools\Agnostic
 */
trait Events
{
    /**
     * @param string $event
     * @param string $handler
     *
     * @return Events|Schema
     * @throws ErrorRuntime
     */
    protected function addEvent(string $event, string $handler): self
    {
        $supported = [
            'retrieved',
            'creating',
            'created',
            'updating',
            'updated',
            'saving',
            'saved',
            'deleting',
            'deleted',
            'trashed',
            'forceDeleted',
            'restoring',
            'restored',
            'replicating',
        ];
        if (!in_array($event, $supported)) {
            throw new ErrorRuntime(['event' => 'not-supported']);
        }
        $this->dispatchesEvents[$event] = $handler;
        return $this;
    }
}
