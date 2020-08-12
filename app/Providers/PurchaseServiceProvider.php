<?php

namespace App\Providers;

use App\Purchase\Contracts\PurchaseCreatable;
use App\Purchase\Contracts\PurchaseProductCreatable;
use App\Purchase\Contracts\PurchaseRemovable;
use App\Purchase\Contracts\PurchaseRetrievable;
use App\Purchase\Contracts\PurchaseUpdatable;
use App\Purchase\Services\PurchaseCreator;
use App\Purchase\Services\PurchaseProductCreator;
use App\Purchase\Services\PurchaseRemover;
use App\Purchase\Services\PurchaseRetriever;
use App\Purchase\Services\PurchaseUpdater;
use Illuminate\Support\ServiceProvider;

class PurchaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PurchaseProductCreatable::class, PurchaseProductCreator::class);
        $this->app->bind(PurchaseRetrievable::class, PurchaseRetriever::class);
        $this->app->bind(PurchaseCreatable::class, PurchaseCreator::class);
        $this->app->bind(PurchaseUpdatable::class, PurchaseUpdater::class);
        $this->app->bind(PurchaseRemovable::class, PurchaseRemover::class);
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
