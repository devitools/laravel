<?php

declare(strict_types=1);

namespace Devitools\Http\Controllers\Rest;

use Illuminate\Http\Request;

/**
 * Trait Data
 *
 * @package Devitools\Http\Controllers\Rest
 */
trait Data
{
    /**
     * @param Request $request
     *
     * @return array
     */
    protected function getData(Request $request): array
    {
        return $request->all();
    }
}
