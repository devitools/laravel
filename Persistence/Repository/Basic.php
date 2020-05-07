<?php

declare(strict_types=1);

namespace DeviTools\Persistence\Repository;

use DeviTools\Exceptions\ErrorInvalidArgument;
use DeviTools\Persistence\AbstractModel;
use DeviTools\Persistence\Filter\Connectors;
use DeviTools\Persistence\Filter\Operators;
use Illuminate\Database\Eloquent\Builder;

use function call_user_func_array;
use function DeviTools\Helper\numberToCurrency;
use function in_array;
use function is_array;

/**
 * Trait Basic
 *
 * @package DeviTools\Persistence\Repository
 * @property AbstractModel model
 */
trait Basic
{
    /**
     * @return string
     */
    public function prefix(): string
    {
        return $this->model->prefix();
    }

    /**
     * @param string $id
     * @param bool $trash
     *
     * @return AbstractModel
     */
    public function pull(string $id, bool $trash = false): ?AbstractModel
    {
        if ($trash) {
            return $this->where($this->filterById($id))->withTrashed()->get($this->model->columns())->first();
        }
        return $this->where($this->filterById($id))->get($this->model->columns())->first();
    }

    /**
     * @param array $filters
     * @param bool $trash
     *
     * @return AbstractModel|Builder
     */
    protected function where(array $filters, bool $trash = false)
    {
        $model = clone $this->model;
        $encoded = $model->getEncoded();

        if ($trash) {
            $model = $model::onlyTrashed();
        }

        $where = function (Builder $query) use ($filters, $encoded) {
            $model = $query;
            foreach ($filters as $column => $value) {
                if (is_array($value)) {
                    $model = $this->whereParse($model, $column, $value);
                    continue;
                }
                if (in_array($column, $encoded, true)) {
                    $value = $this->model::encodeUuid($value);
                }
                $model = $model->where($column, $value);
            }
        };
        return $model->where($where);
    }

    /**
     * @param AbstractModel|Builder $model
     * @param string $column
     * @param array $value
     *
     * @return AbstractModel|Builder
     * @throws ErrorInvalidArgument
     */
    protected function whereParse($model, string $column, array $value)
    {
        if (isset($value['operator'], $value['value'])) {
            return $this->whereParseOperator($model, $column, $value);
        }
        if (isset($value['in'])) {
            return $model->whereIn($column, $value['in']);
        }
        throw new ErrorInvalidArgument($value, "Invalid where to '{$column}'");
    }

    /**
     * @param AbstractModel|Builder $model
     * @param string $column
     * @param array $entry
     *
     * @return AbstractModel|Builder
     */
    protected function whereParseOperator($model, string $column, array $entry)
    {
        $connector = $entry['connector'] ?? Connectors::AND_CONNECTOR;
        $operator = strtolower($entry['operator'] ?? Operators::EQUAL);
        $value = $entry['value'] ?? null;

        $operator = Operators::sign($operator);

        $method = 'filter' . ucfirst($operator);
        if (method_exists($this, $method)) {
            /** @noinspection VariableFunctionsUsageInspection */
            return call_user_func_array([$this, $method], [$model, $column, $connector, $value]);
        }

        switch ($operator) {
            case Operators::LIKE:
                $value = "%{$value}%";
                break;
            case Operators::CURRENCY:
                $operator = '=';
                $value = numberToCurrency($value);
                break;
            case 'nin':
                $value = explode(',', $value);
                if ($connector === Connectors::OR_CONNECTOR) {
                    return $model->orWhereNotIn($column, $value);
                }
                return $model->whereNotIn($column, $value);
        }

        if ($connector === Connectors::OR_CONNECTOR) {
            return $model->orWhere($column, $operator, $value);
        }
        return $model->where($column, $operator, $value);
    }

    /**
     * @param string $id
     *
     * @return array
     */
    protected function filterById(string $id): array
    {
        $key = $this->referenceKey();
        return [
            $key => AbstractModel::encodeUuid($id)
        ];
    }
}