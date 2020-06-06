<?php

namespace App\Providers;

use App\DistributorConnection\Contracts\DistributorConnectionCreatable;
use App\DistributorConnection\Contracts\DistributorConnectionUpdatable;
use App\DistributorConnection\Services\DistributorConnectionCreator;
use App\DistributorConnection\Services\DistributorConnectionUpdater;
use Illuminate\Support\ServiceProvider;

class DistributorConnectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DistributorConnectionCreatable::class, DistributorConnectionCreator::class);
        $this->app->bind(DistributorConnectionUpdatable::class, DistributorConnectionUpdater::class);
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
