<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rest;

use App\Exceptions\ErrorResourceIsGone;
use App\Http\Support\Scopes;
use App\Persistence\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Trait Update
 *
 * @package App\Http\Controllers\Rest
 * @method RepositoryInterface repository()
 */
trait Update
{
    /**
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     * @throws ErrorResourceIsGone
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $this->validate($this->repository()->domain(), Scopes::SCOPE_EDIT);

        $data = $request->all();
        if (!$data) {
            return $this->answerFail(['payload' => 'empty']);
        }
        $details = ['id' => $id];

        $updated = $this->repository()->update($id, $data);
        if ($updated) {
            return $this->answerSuccess(['ticket' => $updated]);
        }
        if ($updated === null) {
            throw new ErrorResourceIsGone($details);
        }
        return $this->answerFail($details);
    }
}