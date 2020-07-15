<?php

declare(strict_types=1);

namespace Devitools\Persistence\Model;

use Devitools\Persistence\AbstractModel;
use Php\JSON;

use function count;
use function in_array;

/**
 * Trait Fill
 *
 * @package Devitools\Persistence\Model
 */
trait Fill
{
    /**
     * @var array
     */
    protected $filled = [];

    /**
     * @param array $attributes
     *
     * @return $this|AbstractModel
     */
    public function fill(array $attributes)
    {
        if (!count($attributes)) {
            /** @var AbstractModel $this */
            return $this;
        }

        $fillable = $this->getFillable();
        $keys = array_keys($attributes);
        $data = [];
        foreach ($fillable as $field) {
            if (!in_array($field, $keys, true)) {
                continue;
            }
            if (!is_scalar($attributes[$field])) {
                $data[$field] = JSON::encode($attributes[$field]);
                continue;
            }
            $data[$field] = $attributes[$field];
        }

        /** @var AbstractModel $fill */
        $fill = parent::fill($data);
        $notFillable = array_diff($keys, $fillable);
        foreach ($notFillable as $field) {
            if (!in_array($field, $keys, true)) {
                continue;
            }
            $this->setFilled($field, $attributes[$field]);
        }
        return $fill;
    }

    /**
     * @param string $key
     * @param null $fallback
     *
     * @return mixed
     */
    public function getFilled(string $key, $fallback = null)
    {
        $keys = array_keys($this->filled);
        if (in_array($key, $keys, true)) {
            return $this->filled[$key];
        }
        return $fallback ?? __UNDEFINED__;
    }

    /**
     * @param string $key
     * @param $value
     *
     * @return $this|AbstractModel
     */
    public function setFilled(string $key, $value)
    {
        $this->filled[$key] = $value;
        return $this;
    }
}
