<?php

declare(strict_types=1);

namespace DeviTools\Http\Rest;

use DeviTools\Exceptions\ErrorResourceIsGone;
use DeviTools\Persistence\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function count;
use function preg_match_all;
use function explode;
use function array_diff;

/**
 * Trait Delete
 *
 * @package DeviTools\Http\Rest
 * @method RepositoryInterface repository()
 */
trait Destroy
{
    /**
     * @param Request $request
     * @param string $id
     * @param bool $erase
     *
     * @return JsonResponse
     * @throws ErrorResourceIsGone
     */
    public function destroy(Request $request, string $id, $erase = false): JsonResponse
    {
        $ids = [$id];
        preg_match_all("/^\[(?<uuid>.*)]$/", $id, $matches);
        if (isset($matches['uuid'][0])) {
            $ids = explode(',', $matches['uuid'][0]);
        }

        $executed = [];
        foreach ($ids as $detail) {
            $deleted = $this->repository()->destroy($detail, $erase);
            if ($deleted === null) {
                continue;
            }
            $executed[] = $detail;
        }

        if (count($ids) !== count($executed)) {
            throw new ErrorResourceIsGone(['id' => array_diff($ids, $executed)]);
        }
        return $this->answerSuccess(['ticket' => $ids]);
    }

    /**
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     * @throws ErrorResourceIsGone
     */
    public function erase(Request $request, string $id): JsonResponse
    {
        return $this->destroy($request, $id, true);
    }
}
