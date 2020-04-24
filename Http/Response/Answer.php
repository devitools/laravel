<?php

declare(strict_types=1);

namespace Simples\Response\Answer;

use Simples\Http\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

/**
 * Class Answer
 *
 * @package Simples\Response\Answer
 */
abstract class Answer
{
    /**
     * @param mixed $data
     * @param array $meta
     * @param int $code
     *
     * @return JsonResponse
     */
    public static function success($data, array $meta, int $code = Status::CODE_200)
    {
        $response = [
            'status' => 'success',
            'data' => $data,
            'meta' => $meta,
        ];
        return Response::json($response, $code);
    }

    /**
     * @param mixed $data
     * @param array $meta
     * @param int $code
     *
     * @return JsonResponse
     */
    public static function fail($data, array $meta, int $code = Status::CODE_400)
    {
        $response = [
            'status' => 'fail',
            'data' => $data,
            'meta' => $meta,
        ];
        return Response::json($response, $code);
    }

    /**
     * @param string $message
     * @param int $code
     * @param mixed $meta
     * @param bool $commit
     * @param bool $debug
     *
     * @return JsonResponse
     */
    public static function error($message, $code = Status::CODE_500, $meta = null, $commit = null, $debug = null)
    {
        $response = [
            'commit' => $commit,
            'status' => 'error',
            'message' => $message,
        ];

        if (!is_null($code)) {
            $response['code'] = $code;
        }

        if (!is_null($meta)) {
            $response['meta'] = $meta;
        }

        if (!is_null($debug)) {
            $response['$debug'] = $debug;
        }

        return Response::json($response, $code);
    }
}
