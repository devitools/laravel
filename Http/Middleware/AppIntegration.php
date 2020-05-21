<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class AppIntegration
 *
 * @package App\Http\Middleware
 */
class AppIntegration
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $jwtHeaderName = config('jwt.token_key_name');
        if ($request->hasHeader($jwtHeaderName)) {
            return $next($request);
        }

        $authHeaderName = env('INTEGRATOR_STATIC_HEADER_NAME', 'integration');
        $authHeaderValue = env('INTEGRATOR_STATIC_HEADER_VALUE');
        if ($request->header($authHeaderName) === $authHeaderValue) {
            return $next($request);
        }

        throw new UnauthorizedHttpException('integration-auth', 'The integration is not configured');
    }
}
