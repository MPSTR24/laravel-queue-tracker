<?php

namespace Mpstr24\QueueTracker;

use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
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

        Event::listen(JobProcessing::class, function (JobProcessing $event) {
            // when job starts processing add to cache so we can retrieve it in the command

            // get queue
            $queue = $event->job->getQueue() ?: 'default';

            // make cache key
            $cache_key = 'queue_tracker_'.$queue;
            // using $queue so the user can pick

            try {
                $job_name = $event->job->resolveName();
            } catch (\Exception $e) {
                $job_name = get_class($event->job);
            }

            // add that job name to cache for 30 minutes in case the job is huge
            Cache::put($cache_key, $job_name, now()->addMinutes(30));

        });

        Event::listen(JobProcessed::class, function (JobProcessed $event) {
            // clear that queue's cache
            $this->clearCache($event);
        });

        Event::listen(JobFailed::class, function (JobFailed $event) {
            // clear that queue's cache
            $this->clearCache($event);
        });
    }

    private function clearCache($event): void
    {
        $queue = $event->job->getQueue() ?: 'default';
        $cache_key = 'queue_tracker_'.$queue;
        Cache::forget($cache_key);
    }
}
