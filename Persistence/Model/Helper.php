<?php

declare(strict_types=1);

namespace DeviTools\Persistence\Model;

use function App\Helper\decodeUuid;
use function App\Helper\encodeUuid;

/**
 * Trait Helper
 *
 * @package DeviTools\Persistence\Model
 */
trait Helper
{
    /**
     * @param $value
     *
     * @return string
     */
    public static function encodeUuid($value): ?string
    {
        if (!$value) {
            return null;
        }
        return encodeUuid($value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public static function decodeUuid($value): ?string
    {
        if (!$value) {
            return null;
        }
        return decodeUuid($value);
    }
}