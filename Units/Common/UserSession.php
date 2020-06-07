<?php

declare(strict_types=1);

namespace Devitools\Units\Common;

use Devitools\Auth\Login;
use Devitools\Exceptions\ErrorUserForbidden;

/**
 * Trait UserSession
 *
 * @package Devitools\Units\Common
 */
trait UserSession
{
    /**
     * @return Login
     * @throws ErrorUserForbidden
     */
    protected function getUser(): Login
    {
        /** @var Login $user */
        $user = auth()->user();
        if (!$user) {
            throw new ErrorUserForbidden(['user' => 'forbidden']);
        }
        return $user;
    }
}
