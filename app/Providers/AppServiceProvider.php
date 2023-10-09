<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::if('can', function ($value) {
            return ( isset(auth()->user()->userPermission()[$value]) OR isset(auth()->user()->userPermission()['*']) ?? false);
        });
    }
}
