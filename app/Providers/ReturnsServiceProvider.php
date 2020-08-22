<?php

namespace App\Providers;

use App\Returns\Contracts\ReturnsCreatable;
use App\Returns\Contracts\ReturnsMorphCreatable;
use App\Returns\Contracts\ReturnsRemovable;
use App\Returns\Contracts\ReturnsRetrievable;
use App\Returns\Contracts\ReturnsUpdatable;
use App\Returns\Services\ReturnsCreator;
use App\Returns\Services\ReturnsMorphCreator;
use App\Returns\Services\ReturnsRemover;
use App\Returns\Services\ReturnsRetriever;
use App\Returns\Services\ReturnsUpdater;
use Illuminate\Support\ServiceProvider;

class ReturnsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ReturnsRetrievable::class, ReturnsRetriever::class);
        $this->app->bind(ReturnsCreatable::class, ReturnsCreator::class);
        $this->app->bind(ReturnsMorphCreatable::class, ReturnsMorphCreator::class);
        $this->app->bind(ReturnsUpdatable::class, ReturnsUpdater::class);
        $this->app->bind(ReturnsRemovable::class, ReturnsRemover::class);
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
