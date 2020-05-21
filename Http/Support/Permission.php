<?php

declare(strict_types=1);

namespace App\Http\Support;

use App\Auth\Login;

use App\Exceptions\ErrorUserForbidden;

use function App\Helper\error;
use function in_array;

/**
 * Trait Permission
 *
 * @package App\Http\Support
 */
trait Permission
{
    /**
     * @var bool
     */
    protected $allowGuest = false;

    /**
     * @param string $prefix
     * @param string $scope
     *
     * @throws ErrorUserForbidden
     */
    protected function grant(string $prefix, string $scope): void
    {
        /** @var Login $user */
        $user = auth()->user();
        if (!$user && $this->allowGuest) {
            return;
        }

        $namespace = "{$prefix}.{$scope}";
        $permissions = $user->getPermissions()->pluck('namespace')->toArray();
        if (in_array($namespace, $permissions, true)) {
            return;
        }

        throw new ErrorUserForbidden(['namespace' => error('namespace', 'required', $namespace)]);
    }
}