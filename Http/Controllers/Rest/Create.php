<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rest;

use App\Http\Support\Scopes;
use App\Persistence\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Trait Create
 *
 * @package App\Http\Controllers\Rest
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
        $this->grant($this->repository()->prefix(), Scopes::SCOPE_ADD);

        $data = $request->all();
        if (!$data) {
            return $this->answerFail(['payload' => 'empty']);
        }

        $created = $this->repository()->create($data);

        return $this->answerSuccess(['ticket' => $created]);
    }
}
