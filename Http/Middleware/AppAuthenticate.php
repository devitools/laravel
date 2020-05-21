<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Source\Http\Routing\AppJWTAuthentication;
use Tymon\JWTAuth\Http\Middleware\Authenticate;
use Tymon\JWTAuth\JWTAuth;

/**
 * Class AppAuthenticate
 *
 * @package App\Http\Middleware
 */
class AppAuthenticate extends Authenticate
{
    /**
     * The JWT Authenticator.
     *
     * @var AppJWTAuthentication
     */
    protected $integrator;

    /**
     * Create a new BaseMiddleware instance.
     *
     * @param JWTAuth $auth
     * @param AppJWTAuthentication $integrator
     */
    public function __construct(JWTAuth $auth, AppJWTAuthentication $integrator)
    {
        parent::__construct($auth);
        $this->integrator = $integrator;
    }

    /**
     * @param Request $request
     *
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function authenticate(Request $request)
    {
        $header = env('INTEGRATOR_AUTH_HEADER_NAME', 'authorization');
        $prefix = env('INTEGRATOR_AUTH_HEADER_PREFIX', 'falcon');
        if ($this->integrate($request, $header, $prefix)) {
            return;
        }
        parent::authenticate($request);
    }

    /**
     * @param Request $request
     * @param string $header
     * @param string $prefix
     *
     * @return bool
     */
    private function integrate(Request $request, string $header, string $prefix): bool
    {
        if (!$request->hasHeader($header)) {
            return false;
        }

        $authorization = $request->header($header);
        if (strpos($authorization, $prefix) === false) {
            return false;
        }

        return (bool)$this->integrator->setup($authorization, $prefix)->authenticate();
    }
}
