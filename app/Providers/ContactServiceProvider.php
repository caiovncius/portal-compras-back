<?php

namespace App\Providers;

use App\Contact\Contracts\ContactCreatable;
use App\Contact\Contracts\ContactRemovable;
use App\Contact\Contracts\ContactRetrievable;
use App\Contact\Contracts\ContactUpdatable;
use App\Contact\Services\ContactCreator;
use App\Contact\Services\ContactRemover;
use App\Contact\Services\ContactRetriever;
use App\Contact\Services\ContactUpdater;
use Illuminate\Support\ServiceProvider;

class ContactServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContactRetrievable::class, ContactRetriever::class);
        $this->app->bind(ContactCreatable::class, ContactCreator::class);
        $this->app->bind(ContactUpdatable::class, ContactUpdater::class);
        $this->app->bind(ContactRemovable::class, ContactRemover::class);
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
