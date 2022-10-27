<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Perusahaan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('templates.layout', function($view) {
            $view->with('perusahaan', Perusahaan::first());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
