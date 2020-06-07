<?php

namespace App\Providers;

use App\Accompaniment\Contracts\AccompanimentCreatable;
use App\Accompaniment\Contracts\AccompanimentRemovable;
use App\Accompaniment\Contracts\AccompanimentRetrievable;
use App\Accompaniment\Contracts\AccompanimentUpdatable;
use App\Accompaniment\Services\AccompanimentCreator;
use App\Accompaniment\Services\AccompanimentRemover;
use App\Accompaniment\Services\AccompanimentRetriever;
use App\Accompaniment\Services\AccompanimentUpdater;
use Illuminate\Support\ServiceProvider;

class AccompanimentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AccompanimentRetrievable::class, AccompanimentRetriever::class);
        $this->app->bind(AccompanimentCreatable::class, AccompanimentCreator::class);
        $this->app->bind(AccompanimentUpdatable::class, AccompanimentUpdater::class);
        $this->app->bind(AccompanimentRemovable::class, AccompanimentRemover::class);
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
