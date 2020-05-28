<?php

namespace App\Providers;

use App\User\Contracts\UserCreatable;
use App\User\Contracts\UserRemovable;
use App\User\Contracts\UserRetrievable;
use App\User\Contracts\UserUpdatable;
use App\User\Services\UserCreator;
use App\User\Services\UserRemover;
use App\User\Services\UserRetriever;
use App\User\Services\UserUpdater;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRetrievable::class, UserRetriever::class);
        $this->app->bind(UserCreatable::class, UserCreator::class);
        $this->app->bind(UserUpdatable::class, UserUpdater::class);
        $this->app->bind(UserRemovable::class, UserRemover::class);
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
