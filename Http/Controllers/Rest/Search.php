<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rest;

use App\Http\Support\Scopes;
use App\Persistence\Filter\Connectors;
use App\Persistence\Filter\FilterValue;
use App\Persistence\Filter\Operators;
use App\Persistence\RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Php\JSON;
use Ramsey\Uuid\Uuid;

use function count;
use function explode;
use function is_array;
use function is_numeric;

/**
 * Trait Search
 *
 * @package App\Http\Controllers\Rest
 * @method RepositoryInterface repository()
 */
trait Search
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $this->grant($this->repository()->domain(), Scopes::SCOPE_INDEX);

        // page=1&size=10
        $page = $request->get('page', 1);
        $limit = $request->get('size', 25);
        $trash = $request->get('trash') === 'true';
        $sort = $request->get('sort');
        $filter = $request->get('filter');
        $where = $request->get('where');

        $offset = ($page - 1) * $limit;

        $filters = $this->parseSearch($filter, $where);
        $options = [
            'filters' => $filters,
            'offset' => $offset,
            'limit' => $limit,
            'sorter' => $this->parseSorter($sort)
        ];
        $data = $this->repository()->search($options, $trash);

        $total = $this->repository()->count($filters, $trash);
        $meta = ['total' => $total];
        return $this->answerSuccess($data, $meta);
    }

    /**
     * @param string|null $filter
     * @param array|null $where
     *
     * @return array
     */
    protected function parseSearch(?string $filter, ?array $where): array
    {
        if (!$filter && !$where) {
            return [];
        }
        if ($where) {
            return $this->parseSearchWhere($where, $this->repository()->getManyToOne());
        }
        return $this->parseSearchFast($this->repository()->getFilterable(), $filter);
    }

    /**
     * @param array|null $where
     * @param array $manyToOne
     *
     * @return array
     */
    protected function parseSearchWhere(?array $where, array $manyToOne): array
    {
        if (!is_array($where)) {
            return [];
        }
        $filters = [];
        foreach ($where as $field => $properties) {
            $operator = Operators::EQUAL;
            $pieces = (array)explode(Operators::SEPARATION_OPERATOR, $properties);
            $value = $pieces[0] ?? null;
            if (count($pieces) > 1) {
                [$operator, $value] = $pieces;
            }

            if (!isset($manyToOne[$field])) {
                $filters[$field] = FilterValue::build($value, $operator, Connectors:: AND);
                continue;
            }

            $target = $manyToOne[$field];
            $reference = JSON::decode($value, true);
            $value = $reference['id'] ?? null;
            if (!$value) {
                continue;
            }

            $operator = Operators::EQUAL;
            $value = Uuid::fromString($value)->getBytes();
            $filters[$target] = FilterValue::build($value, $operator, Connectors:: AND);
        }
        return $filters;
    }

    /**
     * @param array $fields
     * @param string|null $filter
     *
     * @return array
     */
    protected function parseSearchFast(array $fields, ?string $filter): array
    {
        if (!$filter || !count($fields)) {
            return [];
        }
        $filters = [];
        foreach ($fields as $field => $operator) {
            if (is_numeric($field)) {
                $field = $operator;
                $operator = Operators::LIKE;
            }
            $filters[$field] = FilterValue::build($filter, $operator, Connectors:: OR);
        }
        return $filters;
    }

    /**
     * @param string|null $sort
     *
     * @return array|null
     */
    protected function parseSorter(?string $sort): ?array
    {
        if (!$sort) {
            return null;
        }
        $pieces = (array)explode('.', $sort);
        if (!isset($pieces[0], $pieces[1])) {
            return null;
        }
        [$key, $value] = $pieces;
        return [$key => $value];
    }
}
