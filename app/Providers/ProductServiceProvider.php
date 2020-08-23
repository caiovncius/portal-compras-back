<?php

namespace App\Providers;

use App\Product\Contracts\ProductCreatable;
use App\Product\Contracts\ProductDetailCreatable;
use App\Product\Contracts\ProductDetailRetrievable;
use App\Product\Contracts\ProductRemovable;
use App\Product\Contracts\ProductRetrievable;
use App\Product\Contracts\ProductUpdatable;
use App\Product\Services\ProductCreator;
use App\Product\Services\ProductDetailCreator;
use App\Product\Services\ProductDetailRetriever;
use App\Product\Services\ProductRemover;
use App\Product\Services\ProductRetriever;
use App\Product\Services\ProductUpdater;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductRetrievable::class, ProductRetriever::class);
        $this->app->bind(ProductDetailCreatable::class, ProductDetailCreator::class);
        $this->app->bind(ProductDetailRetrievable::class, ProductDetailRetriever::class);
        $this->app->bind(ProductCreatable::class, ProductCreator::class);
        $this->app->bind(ProductUpdatable::class, ProductUpdater::class);
        $this->app->bind(ProductRemovable::class, ProductRemover::class);
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
