<?php

namespace App\Providers;

use App\Profile\Contracts\ProfileCreatable;
use App\Profile\Contracts\ProfileRemovable;
use App\Profile\Contracts\ProfileRetrievable;
use App\Profile\Contracts\ProfileUpdatable;
use App\Profile\Services\ProfileCreator;
use App\Profile\Services\ProfileRemover;
use App\Profile\Services\ProfileRetriever;
use App\Profile\Services\ProfileUpdator;
use Illuminate\Support\ServiceProvider;

class ProfileServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProfileCreatable::class, ProfileCreator::class);
        $this->app->bind(ProfileUpdatable::class, ProfileUpdator::class);
        $this->app->bind(ProfileRetrievable::class, ProfileRetriever::class);
        $this->app->bind(ProfileRemovable::class, ProfileRemover::class);
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
