<?php

declare(strict_types=1);

namespace Devitools\Http\Routing;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route as Facade;

/**
 * Class Router
 *
 * @package Devitools\Http\Routing
 */
class Router extends Facade
{
    /**
     * @param string $uri
     * @param string $controller
     */
    public static function api(string $uri, string $controller): void
    {
        // search
        static::get($uri, "{$controller}@search");
        // create
        static::post($uri, "{$controller}@create");
        // read
        static::get("{$uri}/{id}", "{$controller}@read");
        // update
        static::patch("{$uri}/{id}", "{$controller}@update");
        static::post("{$uri}/{id}", "{$controller}@update");
        // destroy
        static::delete("{$uri}/{id}", "{$controller}@destroy");
        // restore
        static::put("{$uri}/{id}/restore", "{$controller}@restore");
        // erase
        static::delete("{$uri}/{id}/erase", "{$controller}@erase");
    }

    /**
     * @return RouteRegistrar
     */
    public static function restricted(): RouteRegistrar
    {
        return static::middleware(config('app.restricted'));
    }
}