<?php

namespace App\Providers;

use App\Publicity\Contracts\PublicityCreatable;
use App\Publicity\Contracts\PublicityRemovable;
use App\Publicity\Contracts\PublicityRetrievable;
use App\Publicity\Contracts\PublicityUpdatable;
use App\Publicity\Services\PublicityCreator;
use App\Publicity\Services\PublicityRemover;
use App\Publicity\Services\PublicityRetriever;
use App\Publicity\Services\PublicityUpdater;
use Illuminate\Support\ServiceProvider;

class PublicityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PublicityRetrievable::class, PublicityRetriever::class);
        $this->app->bind(PublicityCreatable::class, PublicityCreator::class);
        $this->app->bind(PublicityUpdatable::class, PublicityUpdater::class);
        $this->app->bind(PublicityRemovable::class, PublicityRemover::class);
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
