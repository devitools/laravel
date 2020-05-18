<?php

declare(strict_types=1);

namespace DeviTools\Http\Rest;

use DeviTools\Http\Support\Scopes;
use DeviTools\Persistence\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Trait Create
 *
 * @package DeviTools\Http\Rest
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
