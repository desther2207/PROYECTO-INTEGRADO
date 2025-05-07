<?php

namespace App\Providers;

use App\Models\Pair;
use App\Observers\PairObserver;
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
        Pair::observe(PairObserver::class);
    }
}
