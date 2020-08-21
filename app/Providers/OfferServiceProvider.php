<?php

namespace App\Providers;

use App\Offer\Contracts\OfferCreatable;
use App\Offer\Contracts\OfferProductCreatable;
use App\Offer\Contracts\OfferProductRetrievable;
use App\Offer\Contracts\OfferRemovable;
use App\Offer\Contracts\OfferRetrievable;
use App\Offer\Contracts\OfferUpdatable;
use App\Offer\Services\OfferCreator;
use App\Offer\Services\OfferProductCreator;
use App\Offer\Services\OfferProductRetriever;
use App\Offer\Services\OfferRemover;
use App\Offer\Services\OfferRetriever;
use App\Offer\Services\OfferUpdater;
use Illuminate\Support\ServiceProvider;

class OfferServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OfferProductCreatable::class, OfferProductCreator::class);
        $this->app->bind(OfferProductRetrievable::class, OfferProductRetriever::class);
        $this->app->bind(OfferRetrievable::class, OfferRetriever::class);
        $this->app->bind(OfferCreatable::class, OfferCreator::class);
        $this->app->bind(OfferUpdatable::class, OfferUpdater::class);
        $this->app->bind(OfferRemovable::class, OfferRemover::class);
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
