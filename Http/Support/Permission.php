<?php

declare(strict_types=1);

namespace Devitools\Http\Support;

use Devitools\Auth\Login;
use Devitools\Exceptions\ErrorUserForbidden;

use function Devitools\Helper\error;
use function in_array;

/**
 * Trait Permission
 *
 * @package Devitools\Http\Support
 */
trait Permission
{
    /**
     * @var bool
     */
    protected bool $allowGuest = false;

    /**
     * @param string $domain
     * @param string $scope
     *
     * @throws ErrorUserForbidden
     */
    public function grant(string $domain, string $scope): void
    {
        /** @var Login $user */
        $user = auth()->user();
        if (!$user && $this->allowGuest) {
            return;
        }

        $namespace = "{$domain}.{$scope}";
        $permissions = $user
            ->getPermissions()
            ->pluck('namespace')
            ->toArray();
        if (in_array($namespace, $permissions, true)) {
            return;
        }

        throw new ErrorUserForbidden(['namespace' => error('namespace', 'required', $namespace)]);
    }
}
