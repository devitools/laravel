<?php /** @noinspection PhpUnused */

declare(strict_types=1);

namespace DeviTools\Persistence\Model;

/**
 * Trait Replaceable
 *
 * @package DeviTools\Persistence\Model
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
     * @return array
     */
    public function manyToOne(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function manyToMany(): array
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