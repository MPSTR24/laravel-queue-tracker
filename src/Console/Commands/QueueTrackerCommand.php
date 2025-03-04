<?php

namespace Mpstr24\QueueTracker\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class QueueTrackerCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:track {--queue=default : This will be "default" unless specified}';

    protected $description = 'This command will display the current job in the selected queue.';

    public function handle(): int
    {
        $queue = $this->option('queue');
        $cache_key = 'queue_tracker_'.$queue;

        $current_job = Cache::get($cache_key);

        if (!$current_job) {
            $this->info('No job found in queue.');
            return self::SUCCESS;
        }

        $this->info('Currently processing job: '.$current_job);
        return self::SUCCESS;
    }
}
