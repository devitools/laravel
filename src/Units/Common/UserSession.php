<?php

declare(strict_types=1);

namespace Devitools\Units\Common;

use Devitools\Exceptions\ErrorUserForbidden;
use Illuminate\Contracts\Auth\Authenticatable;
use Throwable;

/**
 * Trait UserSession
 *
 * @package Devitools\Units\Common
 */
trait UserSession
{
    /**
     * @return Authenticatable
     * @throws ErrorUserForbidden
     */
    protected function getUser(): Authenticatable
    {
        $user = auth()->user();
        if (!$user) {
            throw new ErrorUserForbidden(['user' => 'forbidden']);
        }
        return $user;
    }

    /**
     * @param string $permission
     *
     * @return bool
     * @throws ErrorUserForbidden
     */
    protected function can(string $permission): bool
    {
        try {
            /** @noinspection PhpPossiblePolymorphicInvocationInspection */
            $permissions = $this->getUser()->getPermissions();
        } catch (Throwable $e) {
            return false;
        }
        return in_array($permission, $permissions, true);
    }
}
