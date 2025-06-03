<?php

declare(strict_types=1);

namespace Devitools\Agnostic\Events;

/**
 * class EventsAvailable
 *
 * @package Devitools\Agnostic\Events
 */
abstract class EventsAvailable
{
    /**
     * @var string
     */
    public const RETRIEVED = 'retrieved';

    /**
     * @var string
     */
    public const CREATING = 'creating';

    /**
     * @var string
     */
    public const CREATED = 'created';

    /**
     * @var string
     */
    public const UPDATING = 'updating';

    /**
     * @var string
     */
    public const UPDATED = 'updated';

    /**
     * @var string
     */
    public const SAVING = 'saving';

    /**
     * @var string
     */
    public const SAVED = 'saved';

    /**
     * @var string
     */
    public const DELETING = 'deleting';

    /**
     * @var string
     */
    public const DELETED = 'deleted';

    /**
     * @var string
     */
    public const TRASHED = 'trashed';

    /**
     * @var string
     */
    public const FORCE_DELETED = 'forceDeleted';

    /**
     * @var string
     */
    public const RESTORING = 'restoring';

    /**
     * @var string
     */
    public const RESTORED = 'restored';

    /**
     * @var string
     */
    public const REPLICATING = 'replicating';

    /**
     * Invalidate the class constructor.
     */
    private function __construct()
    {
    }
}
