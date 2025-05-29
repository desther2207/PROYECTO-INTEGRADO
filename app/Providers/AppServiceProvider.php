<?php

namespace App\Providers;

use App\Models\Pair;
use App\Models\Tournament;
use App\Observers\PairObserver;
use App\Observers\TournamentObserver;
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
        Tournament::observe(TournamentObserver::class);

    }
}
