<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        config(['app.locale' => 'id']);
	    Carbon::setLocale('id');
        Schema::defaultStringLength(191);
        if(env('FORCE_HTTPS',false)) { // Default value should be false for local server
            URL::forceScheme('https');
        }
    }
}
