<?php

namespace App\Providers;

use App\Priority\Contracts\PriorityCreatable;
use App\Priority\Contracts\PriorityRemovable;
use App\Priority\Contracts\PriorityRetrievable;
use App\Priority\Contracts\PriorityUpdatable;
use App\Priority\Services\PriorityCreator;
use App\Priority\Services\PriorityRemover;
use App\Priority\Services\PriorityRetriever;
use App\Priority\Services\PriorityUpdater;
use Illuminate\Support\ServiceProvider;

class PriorityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PriorityCreatable::class, PriorityCreator::class);
        $this->app->bind(PriorityUpdatable::class, PriorityUpdater::class);
        $this->app->bind(PriorityRetrievable::class, PriorityRetriever::class);
        $this->app->bind(PriorityRemovable::class, PriorityRemover::class);
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
