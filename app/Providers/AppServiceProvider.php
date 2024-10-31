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
            if (auth()->check()) {
                return (isset(auth()->user()->userPermission()[$value]) or isset(auth()->user()->userPermission()['*']) ?? false);
            } else {
                return false;
            }
        });

        Blade::directive('set', function ($expression) {
            list($name, $val) = explode(',', $expression);
            return "<?php {$name} = {$val}; ?>";
        });
    }
}
