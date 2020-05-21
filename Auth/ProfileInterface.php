<?php

declare(strict_types=1);

namespace App\Auth;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ProfileInterface
 *
 * @package App\Auth
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
