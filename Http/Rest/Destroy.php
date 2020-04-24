<?php

declare(strict_types=1);

namespace Simples\Http\Rest;

use App\Exceptions\ErrorResourceIsGone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Simples\Persistence\RepositoryInterface;

/**
 * Trait Delete
 *
 * @package Simples\Http\Rest
 * @method RepositoryInterface repository()
 */
trait Destroy
{
    /**
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     * @throws ErrorResourceIsGone
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $erase = $request->get('erase');

        $details = ['id' => $id];
        $deleted = $this->repository()->destroy($id, $erase);
        if ($deleted) {
            return $this->answerSuccess(['ticket' => $deleted]);
        }
        if ($deleted === null) {
            throw new ErrorResourceIsGone($details);
        }
        return $this->answerFail($details);
    }
}