<?php

namespace Mpstr24\QueueTracker;

use Illuminate\Support\ServiceProvider;
use Mpstr24\QueueTracker\Console\Commands\QueueTrackerCommand;

class QueueTrackerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
               QueueTrackerCommand::class,
            ]);
        }
    }
}
