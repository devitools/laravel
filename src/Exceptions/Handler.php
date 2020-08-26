<?php

declare(strict_types=1);

namespace Devitools\Exceptions;

use Devitools\Auth\Login;
use Devitools\Http\Response\AnswerTrait;
use Devitools\Http\Status;
use Exception;
use ForceUTF8\Encoding;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sentry\State\Scope;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

use function Devitools\Helper\url;
use function in_array;
use function is_array;
use function Sentry\configureScope;

/**
 * Class Handler
 *
 * @package Devitools\Exceptions
 */
class Handler extends ExceptionHandler
{
    /**
     * @see AnswerTrait
     */
    use AnswerTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
        'passwordConfirmation',
    ];

    /**
     * Capture errors and send to error tracker with Sentry
     *
     * @requires sentry/sentry-laravel
     * Use "composer require sentry/sentry-laravel" to use Sentry
     *
     * @param Throwable $exception
     */
    public static function capture(Throwable $exception): void
    {
        if (!function_exists('configureScope')) {
            return;
        }

        configureScope(static function (Scope $scope) use ($exception): void {
            # capture the user
            try {
                $user = auth()->user();
                if ($user) {
                    /** @var Login $user */
                    $scope->setUser($user->toArray());
                }
            } catch (Throwable $e) {
            }

            # capture the URL
            $scope->setExtra('url', url(''));

            if (!$exception instanceof ErrorGeneral) {
                return;
            }

            $details = $exception->getDetails();
            foreach ($details as $key => $value) {
                $scope->setExtra((string)$key, $value);
            }
        });
        app('sentry')->captureException($exception);
    }

    /**
     * Report or log an exception.
     *
     * @param Throwable $exception
     *
     * @return void
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception) && app()->bound('sentry')) {
            static::capture($exception);
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     *
     * @return Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        $route = $request->route();
        if (!$route || in_array('api', $route->middleware(), true)) {
            $request->headers->set('Accept', 'application/json');
        }

        if ($exception instanceof ErrorGeneral) {
            return $this->answerWith($exception);
        }

        if ($exception instanceof UnauthorizedHttpException) {
            $message = 'Unauthorized';
            $data = [];
            if ($exception->getMessage() === 'Token has expired') {
                $data['token'] = 'expired';
            }
            return $this->answerError($message, Status::CODE_401, $data);
        }

        if ($exception instanceof QueryException) {
            $bindings = $exception->getBindings();
            if (!is_array($bindings)) {
                $bindings = [$bindings];
            }
            foreach ($bindings as $key => $binding) {
                $bindings[$key] = Encoding::fixUTF8($binding);
            }
            $message = Encoding::fixUTF8($exception->getMessage());
            $data = [
                'sql' => $exception->getSql(),
                'bindings' => $bindings,
            ];
            return $this->answerError($message, Status::CODE_500, $data);
        }

        return parent::render($request, $exception);
    }

    /**
     * @param ErrorGeneral $exception
     *
     * @return JsonResponse
     */
    protected function answerWith(ErrorGeneral $exception)
    {
        $code = $exception->getStatusCode();
        $meta = ['errors' => $exception->getDetails()];

        if ($code >= 400 && $code < 500) {
            return $this->answerFail(null, $meta, $code);
        }

        $message = $exception->getMessage();
        $debug = '';
        if (env('APP_DEBUG')) {
            $debug = utf8_encode($exception->getTraceAsString());
        }
        return $this->answerError($message, $code, $meta, false, $debug);
    }
}
