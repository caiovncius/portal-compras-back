<?php

namespace App\Providers;

use App\User\Contratcs\UserCreatorable;
use App\User\Contratcs\UserUpdatable;
use App\User\Services\UserCreator;
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
        $this->app->bind(UserCreatorable::class, UserCreator::class);
        $this->app->bind(UserUpdatable::class, UserUpdater::class);
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
