<?php

declare(strict_types=1);

namespace Devitools\Helper;

use DeviTools\Persistence\Value\Currency;
use Exception;
use Ramsey\Uuid\Uuid;

use TypeError;

use function is_int;
use function PhpBrasil\Collection\Helper\stringify;
use function request;

/**
 * @return string
 * @throws Exception
 */
function uuid()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        random_int(0, 0xffff),
        random_int(0, 0xffff),

        // 16 bits for "time_mid"
        random_int(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        random_int(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        random_int(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        random_int(0, 0xffff),
        random_int(0, 0xffff),
        random_int(0, 0xffff)
    );
}

/**
 * @param $value
 *
 * @return string
 */
function encodeUuid($value): string
{
    return Uuid::fromString($value)->getBytes();
}

/**
 * @param $value
 *
 * @return string
 */
function decodeUuid($value): string
{
    return Uuid::fromBytes($value)->toString();
}

/**
 * @param string $content
 *
 * @return bool
 */
function is_binary($content)
{
    if (!is_scalar($content)) {
        return false;
    }
    return preg_match('~[^\x20-\x7E\t\r\n]~', stripAccents($content)) > 0;
}

/**
 * @param string $withAccents
 *
 * @return string
 */
function stripAccents(string $withAccents): string
{
    /** @noinspection SpellCheckingInspection */
    return strtr(
        $withAccents,
        'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
        'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
    );
}

/**
 * @param $path
 *
 * @return string
 */
function url($path)
{
    return env('APP_URL') . str_replace('//', '/', "/{$path}");
}

/**
 * @param string $property
 * @param string $message
 * @param $value
 * @param array $parameters
 * @param null $code
 *
 * @return array
 */
function error(string $property, string $message, $value, $parameters = [], $code = null)
{
    return [
        'property_path' => $property,
        'message' => $message,
        'value' => $value,
        'parameters' => $parameters,
        'code' => $code,
    ];
}

/**
 * @param float|int|null $number
 *
 * @return int
 */
function numberToCurrency($number): int
{
    return Currency::fromNumber($number)->toInteger();
}

/**
 * @param int|Currency|null $currency
 *
 * @return float
 */
function currencyToNumber($currency): float
{
    if ($currency instanceof Currency) {
        return $currency->toNumber();
    }
    if ($currency === null) {
        $currency = 0;
    }
    if (!is_int($currency)) {
        $string = stringify($currency);
        throw new TypeError("Currency must be int or Currency, '{$string}' given");
    }
    return Currency::fromInteger($currency)->toNumber();
}

/**
 * @param int|Currency|null $currency
 *
 * @return string
 */
function currencyFormat($currency): string
{
    $number = currencyToNumber($currency);
    return number_format($number, env('APP_PRECISION', 2), ',', '.');
}

/**
 * @param string $text
 *
 * @return bool
 */
function is_dot(string $text): bool
{
    return ((int)strpos($text, '.')) > 1;
}

/**
 * @return string|null
 */
function ip()
{
    return request()->ip();
}
