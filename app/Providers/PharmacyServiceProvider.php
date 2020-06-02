<?php

namespace App\Providers;

use App\Pharmacy\Contracts\PharmacyCreatable;
use App\Pharmacy\Contracts\PharmacyRemovable;
use App\Pharmacy\Contracts\PharmacyRetrievable;
use App\Pharmacy\Contracts\PharmacyUpdatable;
use App\Pharmacy\Services\PharmacyCreator;
use App\Pharmacy\Services\PharmacyRemover;
use App\Pharmacy\Services\PharmacyRetriever;
use App\Pharmacy\Services\PharmacyUpdator;
use Illuminate\Support\ServiceProvider;

class PharmacyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PharmacyCreatable::class, PharmacyCreator::class);
        $this->app->bind(PharmacyUpdatable::class, PharmacyUpdator::class);
        $this->app->bind(PharmacyRetrievable::class, PharmacyRetriever::class);
        $this->app->bind(PharmacyRemovable::class, PharmacyRemover::class);
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
