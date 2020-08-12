<?php

namespace App\Providers;

use App\Request\Contracts\RequestCreatable;
use App\Request\Contracts\RequestRemovable;
use App\Request\Contracts\RequestRetrievable;
use App\Request\Contracts\RequestUpdatable;
use App\Request\Services\RequestCreator;
use App\Request\Services\RequestProductCreator;
use App\Request\Services\RequestRemover;
use App\Request\Services\RequestRetriever;
use App\Request\Services\RequestUpdater;
use Illuminate\Support\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RequestCreatable::class, RequestCreator::class);
        $this->app->bind(RequestRetrievable::class, RequestRetriever::class);
        $this->app->bind(RequestCreatable::class, RequestCreator::class);
        $this->app->bind(RequestUpdatable::class, RequestUpdater::class);
        $this->app->bind(RequestRemovable::class, RequestRemover::class);
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
