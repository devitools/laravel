<?php

declare(strict_types=1);

namespace Devitools\Auth;

use Devitools\Exceptions\ErrorUserInative;
use Devitools\Exceptions\ErrorUserUnauthorized;
use Devitools\Units\Common\Instance;
use Exception;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

use function Devitools\Helper\uuid;

/**
 * Class Session
 *
 * @package Source\Domains\Auth
 */
class Session extends Login
{
    /**
     * @trait
     */
    use Instance;

    /**
     * @param string $username
     * @param string $password
     * @param string $device
     *
     * @return array
     * @throws ErrorUserInative
     * @throws ErrorUserUnauthorized
     */
    public function login(string $username, string $password, string $device = ''): array
    {
        $login = static::where('username', $username)->first();

        if ($login === null) {
            throw new ErrorUserUnauthorized(['credentials' => 'unknown']);
        }

        if (!Hash::check($password, $login->getAttribute('password'))) {
            throw new ErrorUserUnauthorized(['credentials' => 'invalid']);
        }

        if (!$login->getAttribute('active')) {
            throw new ErrorUserInative(['user' => 'inactive']);
        }

        return $this->credentials($login, $device);
    }

    /**
     * @param Login $user
     * @param string $device
     *
     * @return array
     * @throws ErrorUserUnauthorized
     * @throws Exception
     */
    protected function credentials(Login $user, string $device): array
    {
        $session = uuid();
        $id = $user->getAttribute('id');

        Cache::forever($session, ['id' => $id, 'device' => $device]);

        $customClaims = [
            'session' => $session
        ];
        /** @noinspection PhpUndefinedMethodInspection */
        $token = JWTAuth::claims($customClaims)->fromUser($user);

        if (!$token) {
            throw new ErrorUserUnauthorized(['credentials' => 'invalid']);
        }

        /** @noinspection PhpUndefinedMethodInspection */
        $token_expires_at = JWTAuth::setToken($token)->getPayload()->get('exp');

        return [
            'token' => $token,
            'token_type' => 'bearer',
            'token_expires_at' => $token_expires_at,
            'session' => $session,
            'type' => $user->getReference(),
        ];
    }
}
