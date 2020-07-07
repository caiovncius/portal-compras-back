<?php

namespace App\Providers;

use App\Program\Contracts\ProgramCreatable;
use App\Program\Contracts\ProgramRemovable;
use App\Program\Contracts\ProgramRetrievable;
use App\Program\Contracts\ProgramUpdatable;
use App\Program\Services\ProgramCreator;
use App\Program\Services\ProgramRemover;
use App\Program\Services\ProgramRetriever;
use App\Program\Services\ProgramUpdater;
use Illuminate\Support\ServiceProvider;

class ProgramServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProgramRetrievable::class, ProgramRetriever::class);
        $this->app->bind(ProgramCreatable::class, ProgramCreator::class);
        $this->app->bind(ProgramUpdatable::class, ProgramUpdater::class);
        $this->app->bind(ProgramRemovable::class, ProgramRemover::class);
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
