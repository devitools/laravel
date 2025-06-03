<?php

declare(strict_types=1);

namespace Devitools\Helper;

use Devitools\Exceptions\ErrorInvalidArgument;
use Devitools\Persistence\Filter\Filters;
use Devitools\Persistence\Value\Currency;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JsonException;
use Ramsey\Uuid\Uuid;
use Throwable;
use TypeError;

use function is_int;
use function PhpBrasil\Collection\Helper\stringify;
use function request;

/**
 * @return string
 * @throws Exception
 */
function uuid(): string
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
 * @param string $value
 *
 * @return string
 */
function encodeUuid(string $value): string
{
    return Uuid::fromString($value)->getBytes();
}

/**
 * @param string $value
 *
 * @return string
 */
function decodeUuid(string $value): string
{
    return Uuid::fromBytes($value)->toString();
}

/**
 * @param $content
 *
 * @return bool
 */
function is_binary($content): bool
{
    if (!is_scalar($content)) {
        return false;
    }
    return preg_match('~[^\x20-\x7E\t\r\n]~', stripAccents((string)$content)) > 0;
}

/**
 * @param string $value
 *
 * @return string
 */
function stripAccents(string $value): string
{
    return strtr(
        $value,
        'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
        'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
    );
}

/**
 * @param string $path
 *
 * @return string
 */
function url(string $path): string
{
    return env('APP_URL') . str_replace('//', '/', "/{$path}");
}

/**
 * @param string $property
 * @param string $message
 * @param $value
 * @param array $parameters
 * @param null $domain
 *
 * @return array
 */
function error(string $property, string $message, $value, array $parameters = [], $domain = null): array
{
    return [
        'property_path' => $property,
        'message' => $message,
        'value' => $value,
        'parameters' => $parameters,
        'domain' => $domain,
    ];
}

/**
 * @param float|int|null $number
 *
 * @return int
 */
function numberToCurrency($number): int
{
    try {
        return Currency::fromNumber($number)->toInteger();
    } catch (ErrorInvalidArgument $e) {
        return 0;
    }
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
 * @param int $currency
 * @param bool $prefixed
 *
 * @return string
 */
function currencyFormat(int $currency, bool $prefixed = false): string
{
    $prefix = $prefixed ? env('APP_CURRENCY', '') . ' ' : '';
    $number = currencyToNumber($currency);
    $decimals = env('APP_PRECISION', 2);
    $decimalSeparator = env('APP_DECIMAL_SEPARATOR', '.');
    $thousandSeparator = env('APP_THOUSAND_SEPARATOR', '');
    return $prefix . number_format($number, $decimals, $decimalSeparator, $thousandSeparator);
}

/**
 * @param string $text
 *
 * @return bool
 */
function is_dot(string $text): bool
{
    return ((int)mb_strpos($text, '.')) > 1;
}

/**
 * @return string|null
 */
function ip(): ?string
{
    $native = static fn() => $_SERVER['HTTP_CLIENT_IP']
        ?? $_SERVER['HTTP_X_FORWARDED_FOR']
        ?? $_SERVER['HTTP_X_FORWARDED']
        ?? $_SERVER['HTTP_FORWARDED_FOR']
        ?? $_SERVER['HTTP_FORWARDED']
        ?? $_SERVER['REMOTE_ADDR']
        ?? null;

    $request = request();
    if (!$request instanceof Request) {
        return $native();
    }
    if (!$request->hasHeader('device')) {
        return $native() ?? $request->ip();
    }
    $device = $request->header('device');
    $pieces = explode('@', base64_decode($device));
    if (count($pieces) !== 2) {
        return $native() ?? $request->ip();
    }
    return $pieces[1];
}

/**
 * @param int|null $sleep
 *
 * @return int
 */
function counter(int $sleep = null): int
{
    if ($sleep) {
        sleep(0);
    }
    try {
        $random = (string)random_int(100, 999);
    } catch (Throwable $error) {
        $random = '101';
    }
    $micro = (string)(microtime(true) * 10000);
    $size = 18;
    $counter = mb_substr(str_pad($micro . $random, $size, '0'), 0, $size);
    return (int)$counter;
}

/**
 * @param string $id
 *
 * @return array|string[]
 */
function idToArray(string $id): array
{
    $ids = [$id];
    preg_match_all("/^\[(?<" . __PRIMARY_KEY__ . ">.*)]$/", $id, $matches);
    if (isset($matches[__PRIMARY_KEY__][0])) {
        $ids = explode(',', $matches[__PRIMARY_KEY__][0]);
    }
    return $ids;
}

/**
 * @param string $string
 * @param bool $capitalizeFirst
 *
 * @return string
 */
function dashesToCamelCase(string $string, bool $capitalizeFirst = false): string
{
    $string = str_replace('-', '', ucwords($string, '-'));
    if (!$capitalizeFirst) {
        $string = lcfirst($string);
    }
    return $string;
}

/**
 * Convert array keys to camel case recursively.
 *
 * @param array $array
 *
 * @return array
 */
function camel_keys(array $array): array
{
    $result = [];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $value = camel_keys($value);
        }
        $result[Str::camel($key)] = $value;
    }
    return $result;
}

/**
 * Convert array keys to snake case recursively.
 *
 * @param array $array
 * @param string $delimiter
 *
 * @return array
 */
function snake_keys(array $array, string $delimiter = '_'): array
{
    $result = [];
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $value = snake_keys($value, $delimiter);
        }
        $result[Str::snake($key, $delimiter)] = $value;
    }
    return $result;
}

/**
 * @param string $uuid
 *
 * @return string
 */
function uuidToDatabase(string $uuid): string
{
    $uuid = mb_strtoupper($uuid);
    $pieces = explode('-', $uuid);
    return "0x{$pieces[2]}{$pieces[1]}{$pieces[0]}{$pieces[3]}{$pieces[4]}";
}

/**
 * @return string
 */
function baseURL(): string
{
    $host = filter_input(INPUT_SERVER, 'HTTP_HOST');
    $self = filter_input(INPUT_SERVER, 'PHP_SELF');
    $path = str_replace('/index.php', '', $self);
    return "//{$host}{$path}";
}

/**
 * @param string $value
 * @param string $operator
 *
 * @return string
 */
function withSeparator(string $value, string $operator = 'eq'): string
{
    return $operator . Filters::SEPARATION_OPERATOR . $value;
}

/**
 * @param string $value
 *
 * @return string
 */
function withoutSeparator(string $value): string
{
    $array = explode(Filters::SEPARATION_OPERATOR, $value);
    return array_pop($array);
}

/**
 * @param string $filter
 *
 * @return array|null
 */
function parseSeparator(string $filter): ?array
{
    preg_match_all('/^(?<operator>.*)' . Filters::SEPARATION_OPERATOR . '(?<value>.*)$/', $filter, $matches);
    if (isset($matches['operator'][0], $matches['value'][0])) {
        $value = $matches['value'][0];
        $operator = $matches['operator'][0];
        return ['$value' => $value, '$operator' => $operator];
    }
    return null;
}

/**
 * @param mixed $value
 *
 * @return void
 */
function inspect(mixed $value): void
{
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
    http_response_code(999);
    /** @noinspection ForgottenDebugOutputInspection */
    var_dump($value);
    die;
}

/**
 * @param mixed $value
 *
 * @return void
 */
function debug(mixed $value): void
{
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
    header('Content-Type: application/json');
    http_response_code(999);
    try {
        echo json_encode($value, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    } catch (JsonException $e) {
        echo 'Error on parse JSON: ', $e->getMessage(), PHP_EOL, '--', PHP_EOL;
        /** @noinspection ForgottenDebugOutputInspection */
        var_dump($value);
    }
    die;
}
