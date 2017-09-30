<?php

namespace App\Providers;

use App\Channel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale('zh');

        Blade::if('signIn', function () {
            return auth()->check();
        });

        \View::share('channels', Channel::all());
//        \View::composer('*', function ($view) {
//            $view->with('channels', Channel::all());
//        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
