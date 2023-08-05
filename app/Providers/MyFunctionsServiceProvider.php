<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\MyFunctions;


class MyFunctionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('myfunctions', function () {
            return new MyFunctions();
        });
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
