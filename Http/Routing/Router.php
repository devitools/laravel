<?php

declare(strict_types=1);

namespace DeviTools\Http\Routing;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route as Facade;

/**
 * Class Router
 *
 * @package DeviTools\Http\Routing
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
        // destroy
        static::patch("{$uri}/{id}/restore", "{$controller}@restore");
    }

    /**
     * @return RouteRegistrar
     */
    public static function restricted(): RouteRegistrar
    {
        return static::middleware(config('app.restricted'));
    }
}