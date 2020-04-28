<?php

declare(strict_types=1);

namespace DeviTools\Http\Rest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DeviTools\Persistence\RepositoryInterface;
use Ramsey\Uuid\Uuid;

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
        $data = $request->all();
        if (!$data) {
            return $this->answerFail(['payload' => 'empty']);
        }

        if (!isset($data['id'])) {
            $data['id'] = Uuid::uuid1()->toString();
        }
        $id = $data['id'];
        $created = $this->repository()->create($this->prepareRecord($id, $data));

        return $this->answerSuccess(['ticket' => $created]);
    }
}
