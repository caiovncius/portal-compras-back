<?php

namespace App\Providers;

use App\Laboratory\Contracts\LaboratoryCreatable;
use App\Laboratory\Contracts\LaboratoryRemovable;
use App\Laboratory\Contracts\LaboratoryRetrievable;
use App\Laboratory\Contracts\LaboratoryUpdatable;
use App\Laboratory\Services\LaboratoryCreator;
use App\Laboratory\Services\LaboratoryRemover;
use App\Laboratory\Services\LaboratoryRetriever;
use App\Laboratory\Services\LaboratoryUpdator;
use Illuminate\Support\ServiceProvider;

class LaboratoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LaboratoryCreatable::class, LaboratoryCreator::class);
        $this->app->bind(LaboratoryUpdatable::class, LaboratoryUpdator::class);
        $this->app->bind(LaboratoryRetrievable::class, LaboratoryRetriever::class);
        $this->app->bind(LaboratoryRemovable::class, LaboratoryRemover::class);
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
