<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rest;

use App\Exceptions\ErrorResourceIsGone;
use App\Http\Support\Scopes;
use App\Persistence\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function array_diff;
use function count;
use function App\Helper\idToArray;

/**
 * Trait Restore
 *
 * @package App\Http\Controllers\Rest
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
        $this->grant($this->repository()->prefix(), Scopes::SCOPE_TRASH);

        $ids = idToArray($id);

        $executed = [];
        foreach ($ids as $detail) {
            $restored = $this->repository()->restore($detail);
            if ($restored === null) {
                continue;
            }
            $executed[] = $detail;
        }

        if (count($ids) !== count($executed)) {
            throw new ErrorResourceIsGone(['id' => array_diff($ids, $executed)]);
        }
        return $this->answerSuccess(['ticket' => $ids]);
    }
}