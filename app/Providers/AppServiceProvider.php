<?php

namespace App\Providers;

use App\Models\Coordinador;
use App\Observers\CoordinadorObserver;
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
        Coordinador::observe(CoordinadorObserver::class);
    }
}
