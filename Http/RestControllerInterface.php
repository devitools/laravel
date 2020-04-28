<?php

declare(strict_types=1);

namespace DeviTools\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Interface RestControllerInterface
 *
 * @package DeviTools\Http
 */
interface RestControllerInterface
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse;

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse;

    /**
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function read(Request $request, string $id): JsonResponse;

    /**
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse;

    /**
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function destroy(Request $request, string $id): JsonResponse;

    /**
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function restore(Request $request, string $id): JsonResponse;

    /**
     * @param string $id
     * @param array $data
     *
     * @return array
     */
    public function prepareRecord(string $id, array $data): array;
}
