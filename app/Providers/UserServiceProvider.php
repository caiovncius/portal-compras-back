<?php

namespace App\Providers;

use App\User\Contratcs\UserCreatorable;
use App\User\Services\UserCreator;
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
