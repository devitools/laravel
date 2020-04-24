<?php

declare(strict_types=1);

namespace DeviTools\Persistence\Model;

use DeviTools\Persistence\AbstractModel;

use function count;

/**
 * Trait Fill
 *
 * @package DeviTools\Persistence\Model
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

        $data = [];
        foreach ($this->getFillable() as $fillable) {
            if (!isset($attributes[$fillable])) {
                continue;
            }
            $data[$fillable] = $attributes[$fillable];
        }

        /** @var AbstractModel $fill */
        $fill = parent::fill($data);
        $notFillable = array_diff(array_keys($attributes), $this->getFillable());
        foreach ($notFillable as $key) {
            if (!isset($attributes[$key])) {
                continue;
            }
            $this->setFilled($key, $attributes[$key]);
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
        return $this->filled[$key] ?? $fallback ?? __UNDEFINED__;
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