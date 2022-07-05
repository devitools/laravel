<?php

declare(strict_types=1);

namespace Devitools\Units\Common;

/**
 * Trait Instance
 *
 * @package Source\Domains
 */
trait Instance
{
    /**
     * Create an instance of this class
     *
     * @param array $parameters
     *
     * @return mixed
     */
    public static function instance(array $parameters = [])
    {
        return app(static::class, $parameters);
    }
}
