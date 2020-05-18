<?php

declare(strict_types=1);

namespace DeviTools\Http\Rest;

use DeviTools\Exceptions\ErrorResourceIsGone;
use DeviTools\Http\Support\Scopes;
use DeviTools\Persistence\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Trait Read
 *
 * @package DeviTools\Http\Rest
 * @method RepositoryInterface repository()
 */
trait Read
{
    /**
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     * @throws ErrorResourceIsGone
     */
    public function read(Request $request, string $id): JsonResponse
    {
        $this->grant($this->repository()->prefix(), Scopes::SCOPE_VIEW);

        $trash = $request->get('trash') === 'true';
        $data = $this->repository()->read($id, $trash);
        if ($data === null) {
            throw new ErrorResourceIsGone(['id' => $id]);
        }
        return $this->answerSuccess($data);
    }
}