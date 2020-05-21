<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Exceptions\ErrorInvalidArgument;
use App\Persistence\AbstractModel;
use App\Persistence\Filter\Connectors;
use App\Persistence\Filter\FilterInterface;
use App\Persistence\Filter\FilterValue;
use App\Persistence\Filter\Operators;
use Illuminate\Database\Eloquent\Builder;

use function call_user_func_array;
use function App\Helper\numberToCurrency;
use function in_array;
use function is_array;

/**
 * Trait Basic
 *
 * @package App\Persistence\Repository
 * @property AbstractModel model
 */
trait Basic
{
    /**
     * @var array
     */
    protected array $filters = [];

    /**
     * @return string
     */
    public function domain(): string
    {
        return $this->model->domain();
    }

    /**
     * @return array
     */
    public function currencies(): array
    {
        return $this->model->currencies();
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
        $query = $this->buildQuery($trash);
        $encoded = $this->model->getEncoded();

        return $this->buildWhere($query, $filters, $encoded);
    }

    /**
     * @param bool $trash
     *
     * @return AbstractModel|Builder|\Illuminate\Database\Query\Builder
     */
    protected function buildQuery(bool $trash = false)
    {
        $model = clone $this->model;

        if ($trash) {
            $model = $model::onlyTrashed();
        }
        return $model;
    }

    /**
     * @param AbstractModel|Builder $query
     * @param array $filters
     * @param array $encoded
     *
     * @return AbstractModel|Builder
     */
    protected function buildWhere($query, array $filters, array $encoded = [])
    {
        $where = function (Builder $query) use ($filters, $encoded) {
            $model = $query;
            foreach ($filters as $column => $value) {
                if ($value instanceof FilterValue) {
                    $model = $this->whereFilterValue($model, $column, $value);
                    continue;
                }
                if (in_array($column, $encoded, true)) {
                    $value = $this->model::encodeUuid($value);
                }
                $model = $model->where($column, $value);
            }
        };
        return $query->where($where);
    }

    /**
     * @param Builder $model
     * @param string $column
     * @param FilterValue $filterValue
     *
     * @return AbstractModel|Builder
     */
    protected function whereFilterValue(Builder $model, string $column, FilterValue $filterValue)
    {
        $connector = $filterValue->getConnector();
        $operator = $filterValue->getOperator();
        $value = $filterValue->getValue();

        if (isset($this->filters[$operator])) {
            /** @var FilterInterface $filter */
            $filter = $this->filters[$operator]::build();
            return $filter->query($model, $connector, $value, $column);
        }

        $filter = Operators::filter($operator);
        if ($filter) {
            return $filter->query($model, $connector, $value, $column);
        }

        if ($connector === Connectors::OR) {
            return $model->orWhere($column, $value);
        }
        return $model->where($column, $value);
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