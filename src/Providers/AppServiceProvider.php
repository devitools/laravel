<?php

declare(strict_types=1);

namespace Devitools\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 *
 * @package Devitools\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function boot()
    {
        if ($this->app->environment() !== 'production') {
            return;
        }
        /** @noinspection OffsetOperationsInspection */
        $this->app['request']->server->set('HTTPS', true);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
