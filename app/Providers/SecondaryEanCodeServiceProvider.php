<?php

namespace App\Providers;

use App\SecondaryEacCode\Contracts\SecondaryEanCodeRemovable;
use App\SecondaryEacCode\Contracts\SecondaryEanCodeCreatorable;
use App\SecondaryEacCode\Services\SecondaryEanCodeRemover;
use App\SecondaryEacCode\Services\SecondaryEanCodeCreator;
use Illuminate\Support\ServiceProvider;

class SecondaryEanCodeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SecondaryEanCodeCreatorable::class, SecondaryEanCodeCreator::class);
        $this->app->bind(SecondaryEanCodeRemovable::class, SecondaryEanCodeRemover::class);
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
