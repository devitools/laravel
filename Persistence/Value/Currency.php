<?php

declare(strict_types=1);

namespace DeviTools\Persistence\Value;

use JsonSerializable;

/**
 * Class Currency
 *
 * @package App\Units\Common
 */
class Currency implements JsonSerializable
{
    /**
     * @var string
     */
    private string $amount;

    /**
     * @var string
     */
    private string $cents;

    /**
     * Currency constructor.
     *
     * @param string $amount
     * @param string $cents
     * @param int $precision
     */
    public function __construct(string $amount, string $cents, int $precision)
    {
        $this->amount = $amount;
        $this->cents = str_pad($cents, $precision, '0');
    }

    /**
     * @param float|int $value
     * @param int $precision
     *
     * @return Currency
     */
    public static function fromNumber($value, ?int $precision = null): Currency
    {
        $precision ??= env('APP_PRECISION', 2);
        if ($value === null) {
            return new static('0', '0', $precision);
        }

        if (strpos((string)$value, '.') === false) {
            return new static((string)$value, '0', $precision);
        }

        $string = number_format((float)$value, $precision, '.', '');
        [$amount, $cents] = (array)explode('.', $string);
        return new static((string)$amount, (string)$cents, $precision);
    }

    /**
     * @param int $value
     * @param int $precision
     *
     * @return Currency
     */
    public static function fromInteger(?int $value, ?int $precision = null): Currency
    {
        $precision ??= env('APP_PRECISION', 2);
        if ($value === null) {
            return new static('0', '0', $precision);
        }
        $amount = ($value / (10 ** $precision));
        return new static((string)$amount, '0', $precision);
    }

    /**
     * @return int
     */
    public function toInteger(): int
    {
        return (int)"{$this->amount}{$this->cents}";
    }

    /**
     * @return float
     */
    public function toNumber(): float
    {
        return (float)"{$this->amount}.{$this->cents}";
    }

    /**
     * @return string
     */
    public function toString()
    {
        return (string)$this->toInteger();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4
     */
    public function jsonSerialize()
    {
        return $this->toNumber();
    }
}
