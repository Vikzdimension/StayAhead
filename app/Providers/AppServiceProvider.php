<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Schedules\TaskScheduler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TaskScheduler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->make(TaskScheduler::class)->register(app('Illuminate\Console\Scheduling\Schedule'));
    }
}