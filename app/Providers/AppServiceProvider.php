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
            $user = auth()->user();

            if (auth()->check()) {
                if (session()->has('user_permissions')) {
                    $permissions = session('user_permissions');
                } else {
                    $permissions = $user->userPermission();
                    session(['user_permissions' => $permissions]);
                }

                return isset($permissions[$value]) || isset($permissions['*']);
            }

            return false;
        });

        Blade::directive('set', function ($expression) {
            list($name, $val) = explode(',', $expression);
            return "<?php {$name} = {$val}; ?>";
        });
    }
}
