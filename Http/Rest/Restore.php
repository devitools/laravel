<?php

declare(strict_types=1);

namespace DeviTools\Http\Rest;


use App\Exceptions\ErrorResourceIsGone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DeviTools\Persistence\RepositoryInterface;

use function is_null;

/**
 * Trait Restore
 *
 * @package DeviTools\Http\Rest
 * @method RepositoryInterface repository()
 */
trait Restore
{
    /**
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     * @throws ErrorResourceIsGone
     */
    public function restore(Request $request, string $id): JsonResponse
    {
        $details = ['id' => $id];
        $deleted = $this->repository()->restore($id);
        if ($deleted) {
            return $this->answerSuccess(['ticket' => $deleted]);
        }
        if (is_null($deleted)) {
            throw new ErrorResourceIsGone($details);
        }
        return $this->answerFail($details);
    }
}