<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rest;

use App\Exceptions\ErrorResourceIsGone;
use App\Http\Support\Scopes;
use App\Persistence\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Trait Read
 *
 * @package App\Http\Controllers\Rest
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
        $this->grant($this->repository()->domain(), Scopes::SCOPE_VIEW);

        $trash = $request->get('trash') === 'true';
        $data = $this->repository()->read($id, $trash);
        if ($data === null) {
            throw new ErrorResourceIsGone(['id' => $id]);
        }
        return $this->answerSuccess($data);
    }
}