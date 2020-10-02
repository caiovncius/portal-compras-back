<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use L5Swagger\L5SwaggerServiceProvider;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
