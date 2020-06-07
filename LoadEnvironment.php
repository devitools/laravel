<?php

declare(strict_types=1);

namespace Devitools;

use Dotenv\Dotenv;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Support\Env;

/**
 * Class LoadEnvironment
 *
 * @package Devitools\Http
 */
class LoadEnvironment extends LoadEnvironmentVariables
{

    /**
     * Create a Dotenv instance.
     *
     * @param  Application  $app
     * @return mixed
     */
    protected function createDotenv($app)
    {
        return Dotenv::create(
            Env::getRepository(),
            $app->environmentPath(),
            ['.env.defaults', $app->environmentFile()]
        );
    }
}
