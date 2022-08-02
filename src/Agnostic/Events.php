<?php

declare(strict_types=1);

namespace Devitools\Agnostic;

use Devitools\Agnostic\Events\EventsAvailable;
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
            EventsAvailable::RETRIEVED,
            EventsAvailable::CREATING,
            EventsAvailable::CREATED,
            EventsAvailable::UPDATING,
            EventsAvailable::UPDATED,
            EventsAvailable::SAVING,
            EventsAvailable::SAVED,
            EventsAvailable::DELETING,
            EventsAvailable::DELETED,
            EventsAvailable::TRASHED,
            EventsAvailable::FORCE_DELETED,
            EventsAvailable::RESTORING,
            EventsAvailable::RESTORED,
            EventsAvailable::REPLICATING,
        ];
        if (!in_array($event, $supported, true)) {
            throw new ErrorRuntime(['event' => 'not-supported']);
        }
        $this->dispatchesEvents[$event] = $handler;
        return $this;
    }
}
