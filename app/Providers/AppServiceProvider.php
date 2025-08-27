<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Role-based blade directives
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        Blade::if('inspector', function () {
            return auth()->check() && auth()->user()->canInspect();
        });

        Blade::if('candelete', function () {
            return auth()->check() && auth()->user()->canDelete();
        });

        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->role === $role;
        });
    }
}
