<?php

namespace App\Providers;

use App\Connection\Contracts\ConnectionCreatable;
use App\Connection\Contracts\ConnectionUpdatable;
use App\Connection\Services\ConnectionCreator;
use App\Connection\Services\ConnectionUpdater;
use Illuminate\Support\ServiceProvider;

class ConnectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ConnectionCreatable::class, ConnectionCreator::class);
        $this->app->bind(ConnectionUpdatable::class, ConnectionUpdater::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
