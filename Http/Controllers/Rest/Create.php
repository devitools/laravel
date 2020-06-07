<?php

declare(strict_types=1);

namespace Devitools\Http\Controllers\Rest;

use Devitools\Http\Support\Scopes;
use Devitools\Persistence\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Trait Create
 *
 * @package Devitools\Http\Controllers\Rest
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
        $this->grant($this->repository()->domain(), Scopes::SCOPE_ADD);

        $data = $request->all();
        if (!$data) {
            return $this->answerFail(['payload' => 'empty']);
        }

        $created = $this->repository()->create($data);

        return $this->answerSuccess(['ticket' => $created]);
    }
}
