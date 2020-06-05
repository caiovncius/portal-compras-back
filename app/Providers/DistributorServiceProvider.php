<?php

namespace App\Providers;

use App\Distributor\Contracts\DistributorCreatable;
use App\Distributor\Contracts\DistributorRemovable;
use App\Distributor\Contracts\DistributorRetrievable;
use App\Distributor\Contracts\DistributorUpdatable;
use App\Distributor\Services\DistributorCreator;
use App\Distributor\Services\DistributorRemover;
use App\Distributor\Services\DistributorRetriever;
use App\Distributor\Services\DistributorUpdater;
use Illuminate\Support\ServiceProvider;

class DistributorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DistributorRetrievable::class, DistributorRetriever::class);
        $this->app->bind(DistributorCreatable::class, DistributorCreator::class);
        $this->app->bind(DistributorUpdatable::class, DistributorUpdater::class);
        $this->app->bind(DistributorRemovable::class, DistributorRemover::class);
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
