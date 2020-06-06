<?php

namespace App\Providers;

use App\Condition\Contracts\ConditionCreatable;
use App\Condition\Contracts\ConditionRemovable;
use App\Condition\Contracts\ConditionRetrievable;
use App\Condition\Contracts\ConditionUpdatable;
use App\Condition\Services\ConditionCreator;
use App\Condition\Services\ConditionRemover;
use App\Condition\Services\ConditionRetriever;
use App\Condition\Services\ConditionUpdater;
use Illuminate\Support\ServiceProvider;

class ConditionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ConditionRetrievable::class, ConditionRetriever::class);
        $this->app->bind(ConditionCreatable::class, ConditionCreator::class);
        $this->app->bind(ConditionUpdatable::class, ConditionUpdater::class);
        $this->app->bind(ConditionRemovable::class, ConditionRemover::class);
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
