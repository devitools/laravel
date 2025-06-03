<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace Devitools\Persistence\Model;

/**
 * Trait Replaceable
 *
 * @package Devitools\Persistence\Model
 */
trait Replaceable
{
    /**
     * @var array
     */
    protected array $encoded = [];

    /**
     * @return void
     */
    protected static function configure(): void
    {
    }

    /**
     * @return array
     */
    public function getEncoded(): array
    {
        return $this->encoded;
    }

    /**
     * @return array
     */
    public function sorter(): array
    {
        if (config('app.counter')) {
            return ['counter' => 'ASC'];
        }
        return [static::CREATED_AT => 'ASC'];
    }

    /**
     * @param array|null $sorter
     *
     * @return array
     */
    public function parseSorter(?array $sorter = null): array
    {
        if (!is_array($sorter)) {
            return $this->sorter();
        }

        $manyToOne = $this->manyToOne();
        $parsed = [];
        foreach ($sorter as $field => $type) {
            if (isset($manyToOne[$field])) {
                $column = $manyToOne[$field];
                $parsed[$column] = $type;
                continue;
            }
            $parsed[$field] = $type;
        }
        return $parsed;
    }

    /**
     * @param bool $detailed
     *
     * @return array
     */
    public function manyToOne(bool $detailed = false): array
    {
        return [];
    }

    /**
     * @param bool $detailed
     *
     * @return array
     */
    public function oneToMany(bool $detailed = false): array
    {
        return [];
    }

    /**
     * @param bool $detailed
     *
     * @return array
     */
    public function manyToMany(bool $detailed = false): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function currencies(): array
    {
        return [];
    }
}
