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
            $value = $attributes[$field];
            if (in_array($this->casts[$field] ?? __UNDEFINED__, ['array', 'object'], true)) {
                $value = JSON::encode($value);
            }
            if (is_string($attributes[$field])) {
                $value = str_replace(['>', '<'], ['&gt;', '&lt;'], $value);
            }
            $data[$field] = $value;
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
