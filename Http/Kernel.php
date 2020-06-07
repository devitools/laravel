<?php

declare(strict_types=1);

namespace Devitools\Http;

use Devitools\Http\Middleware\AppAuthenticate;
use Devitools\Http\Middleware\AppIntegration;
use Devitools\Http\Middleware\Authenticate;
use Devitools\Http\Middleware\CheckForMaintenanceMode;
use Devitools\Http\Middleware\EncryptCookies;
use Devitools\Http\Middleware\RedirectIfAuthenticated;
use Devitools\Http\Middleware\TrimStrings;
use Devitools\Http\Middleware\TrustProxies;
use Devitools\Http\Middleware\VerifyCsrfToken;
use Devitools\Persistence\Transaction;
use Fruitcake\Cors\HandleCors;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * Class Kernel
 *
 * @package Devitools\Http
 */
class Kernel extends HttpKernel
{
    /**
     * @var bool
     */
    private static bool $force = false;

    /**
     * The application's global HTTP middleware stack.
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        TrustProxies::class,
        HandleCors::class,
        CheckForMaintenanceMode::class,
        ValidatePostSize::class,
        TrimStrings::class,
        ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'bindings' => SubstituteBindings::class,
        'cache.headers' => SetCacheHeaders::class,
        'can' => Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'password.confirm' => RequirePassword::class,
        'signed' => ValidateSignature::class,
        'throttle' => ThrottleRequests::class,
        'verified' => EnsureEmailIsVerified::class,
    ];

    /**
     * Bootstrap the application for HTTP requests.
     *
     * @return void
     */
    public function bootstrap()
    {
        parent::bootstrap();

        Transaction::start();
    }

    /**
     * Call the terminate method on any terminable middleware.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return void
     */
    public function terminate($request, $response)
    {
        parent::terminate($request, $response);

        Transaction::finish($response);
    }

    /**
     * @return void
     */
    public static function force(): void
    {
        static::$force = true;
    }
}
