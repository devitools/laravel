<?php

declare(strict_types=1);

namespace App\Units\Common;

use App\Auth\Login;
use App\Exceptions\ErrorUserForbidden;

/**
 * Trait UserSession
 *
 * @package App\Units\Common
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
