<?php

namespace Report;

use DateTime;

use function Php\prop;

/**
 * @param mixed $value
 * @param string $property
 * @param null $fallback
 *
 * @return mixed
 */
function property($value, string $property, $fallback = null)
{
    return prop($value, $property, $fallback);
}

/**
 * @param mixed $row
 * @param string $property
 *
 * @return mixed
 */
function value($row, string $property)
{
    return property($row, $property);
}

/**
 * @param mixed $row
 * @param string $property
 * @param int $precision
 * @param string $decimals
 * @param string $thousands
 *
 * @return string
 */
function valueNumber($row, string $property, int $precision = 2, $decimals = ',', $thousands = '.'): string
{
    $value = (float)value($row, $property);
    return number_format($value, $precision, $decimals, $thousands);
}

/**
 * @param mixed $row
 * @param string $property
 * @param array $options
 * @param string $fallback
 *
 * @return string
 */
function valueSelect($row, string $property, array $options, $fallback = '&nbsp;'): string
{
    $value = $row->$property ?? null;
    return $options[$value] ?? $fallback;
}

/**
 * @param mixed $row
 * @param string $property
 * @param string $fallback
 *
 * @return string
 */
function valueDate($row, string $property, string $fallback = ' - '): string
{
    $value = $row->$property ?? null;
    $date = DateTime::createFromFormat('Y-m-d', $value);
    if (!$date) {
        return $fallback;
    }
    return $date->format('d/m/Y');
}

/**
 * @param mixed $row
 * @param string $property
 * @param string $fallback
 *
 * @return string
 */
function valueDatetime($row, string $property, string $fallback = ' - '): string
{
    $value = $row->$property ?? null;
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $value);
    if (!$date) {
        return $fallback;
    }
    return $date->format('d/m/Y H:i:s');
}

/**
 * @param mixed $row
 * @param string $property
 *
 * @return mixed
 */
function responsible($row, string $property)
{
    $regex = '/^(.*)\s\[.*\]/';
    $value = property($row, $property, ' - ');

    preg_match_all($regex, $value, $matches, PREG_SET_ORDER, 0);

    return $matches[0][1] ?? $value;
}
