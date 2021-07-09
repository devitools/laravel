<?php

declare(strict_types=1);

namespace Devitools\Util;

use JsonSerializable;

/**
 * Class Localization
 *
 * @package Devitools\Http\Controllers\Util
 */
final class Localization implements JsonSerializable
{
    /**
     * @var string
     */
    protected string $zip = '';

    /**
     * @var string
     */
    protected string $address = '';

    /**
     * @var string|mixed|null
     */
    protected ?string $complement = null;

    /**
     * @var string
     */
    protected string $neighborhood = '';

    /**
     * @var string
     */
    protected string $city = '';

    /**
     * @var string
     */
    protected string $state = '';

    /**
     * @var string
     */
    protected string $country = '';

    /**
     * @var string
     */
    protected string $ibge = '';

    /**
     * @var string
     */
    protected string $gia = '';

    /**
     * @var float|int|mixed|null
     */
    protected ?float $lat = 0;

    /**
     * @var float|int|mixed|null
     */
    protected ?float $lng = 0;

    /**
     * @var string
     */
    protected string $ddd = '';

    /**
     * @var string
     */
    protected string $siafi = '';


    /**
     * Localization constructor.
     */
    public function __construct(array $data)
    {
        $this->zip = $data['zip'] ?? '';
        $this->address = $data['address'] ?? '';
        $this->complement = $data['complement'] ?? null;
        $this->neighborhood = $data['neighborhood'] ?? '';
        $this->city = $data['city'] ?? '';
        $this->state = $data['state'] ?? '';
        $this->country = $data['country'] ?? '';
        $this->ibge = $data['ibge'] ?? '';
        $this->gia = $data['gia'] ?? '';
        $this->siafi = $data['siafi'] ?? '';
        $this->ddd = $data['ddd'] ?? '';
        $this->lat = $data['lat'] ?? null;
        $this->lng = $data['lng'] ?? null;
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public static function build(array $data): self
    {
        return new self($data);
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
        return get_object_vars($this);
    }
}
