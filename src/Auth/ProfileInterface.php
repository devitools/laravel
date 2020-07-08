<?php

declare(strict_types=1);

namespace Devitools\Auth;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ProfileInterface
 *
 * @package Devitools\Auth
 */
interface ProfileInterface
{
    /**
     * @return string
     */
    public function getReference(): string;

    /**
     * @return Collection
     */
    public function getPermissions(): Collection;
}
