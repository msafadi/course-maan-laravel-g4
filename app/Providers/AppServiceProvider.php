<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if (App::environment('production')) {
            $this->app->bind('path.public', function() {
                return base_path('public_html');
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       
        App::setLocale( request()->query('lang', 'en') );

        Paginator::defaultView('vendor.pagination.bootstrap-4'); // paginate
        Paginator::defaultSimpleView('vendor.pagination.simple-bootstrap-4'); // simplePaginate
    }
}
