<?php

declare(strict_types=1);

namespace Simples\Http\Rest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Simples\Persistence\RepositoryInterface;

/**
 * Trait Create
 *
 * @package Simples\Http\Rest
 * @method RepositoryInterface repository()
 */
trait Create
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->post();
        if (!$data) {
            return $this->answerFail(['payload' => 'empty']);
        }

        $created = $this->repository()->create($data);

        return $this->answerSuccess(['ticket' => $created]);
    }
}