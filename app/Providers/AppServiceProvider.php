<?php

namespace App\Providers;

use App\Modules\Tournament\Repositories\EloquentTeam;
use App\Modules\Tournament\Repositories\TeamRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TeamRepository::class, EloquentTeam::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
