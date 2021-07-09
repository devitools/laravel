<?php

declare(strict_types=1);

namespace Devitools\Util;

use Illuminate\Support\Facades\Cache;
use JsonException;
use Throwable;

/**
 * Class AddressResolver
 *
 * @package Devitools\Http\Controllers\Util
 */
trait AddressResolver
{
    /**
     * @param string $zip
     *
     * @return Localization|null
     */
    protected function resolveZip(string $zip): ?Localization
    {
        $driver = config('devitools.address.driver', 'via-cep');
        $key = "zip:{$driver}-{$zip}";
        if (Cache::has($key)) {
            return Localization::build(Cache::get($key));
        }
        try {
            switch ($driver) {
                case 'google':
                    $via_cep = $this->resolveZipViaCep($zip);
                    $google = $this->resolveZipGoogle($zip) ?? [];
                    $localization = array_merge($via_cep, $google);
                    break;
                case 'via-cep':
                default:
                    $localization = $this->resolveZipViaCep($zip);
            }
        } catch (Throwable $e) {
            return null;
        }
        if (!is_array($localization)) {
            return null;
        }

        $ttl = 60 * 60 * 24 * 3; // 72h
        Cache::put($key, $localization, $ttl);
        return Localization::build($localization);
    }

    /**
     * @param string $zip
     *
     * @return array|null
     * @throws JsonException
     */
    private function resolveZipViaCep(string $zip): ?array
    {
        $payload = file_get_contents("https://viacep.com.br/ws/${zip}/json");
        $info = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        return [
            'zip' => $info['cep'] ?? '',
            'address' => $info['logradouro'] ?? '',
            'complement' => $info['complemento'] ?? '',
            'neighborhood' => $info['bairro'] ?? '',
            'city' => $info['localidade'] ?? '',
            'state' => $info['uf'] ?? '',
            'ibge' => $info['ibge'] ?? '',
            'gia' => $info['gia'] ?? '',
            'siafi' => $info['siafi'] ?? '',
            'ddd' => $info['ddd'] ?? '',
        ];
    }

    /**
     * @param string $zip
     *
     * @return array|null
     * @throws JsonException
     */
    private function resolveZipGoogle(string $zip): ?array
    {
        $key = config('devitools.address.drivers.google.key', '');
        $payload = file_get_contents(
            "https://maps.google.com/maps/api/geocode/json?" .
            "address=${zip}&" .
            "key={$key}"
        );
        $info = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        $results = $info['results'] ?? [];
        $first = $results[0] ?? null;
        $types = $first['types'] ?? [];
        if (!in_array('postal_code', $types, true)) {
            return [];
        }
        $data = [];
        $components = $first['address_components'] ?? [];
        foreach ($components as $component) {
            $types = $component['types'] ?? [];
            if (in_array('country', $types, true)) {
                $data['country'] = $component['short_name'] ?? '';
            }
        }

        $geometry = $first['geometry'] ?? [];
        $location = $geometry['location'] ?? [];

        return [
            'country' => $data['country'] ?? '',
            'lat' => $location['lat'] ?? 0,
            'lng' => $location['lng'] ?? 0,
        ];
    }
}
