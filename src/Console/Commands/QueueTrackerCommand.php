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
    protected $signature = 'queue:track
                                {--queue=default : This will be "default" unless specified}
                                {--watch : Use this to poll the current job in the queue}';

    protected $description = 'This command will display the current job in the selected queue.';

    public function handle(): int
    {
        $queue = $this->normaliseUserInput($this->option('queue'));
        $cache_key = 'queue_tracker_'.$queue;

        if ($this->option('watch')) {
            $this->info('Polling queue every 5 seconds. Press Ctrl+C to exit.');
            // @phpstan-ignore while.alwaysTrue
            while (true) {
                // @phpstan-ignore cast.string
                $current_job = (string)Cache::get($cache_key);

                if (! $current_job) {
                    $this->info('No job found in queue.');
                } else {
                    $this->info('Currently processing job: '.(string)$current_job);
                }

                sleep(5);
            }
        } else {
            // @phpstan-ignore cast.string
            $current_job = (string)Cache::get($cache_key);

            if (! $current_job) {
                $this->info('No job found in queue.');

                return self::SUCCESS;
            }

            $this->info('Currently processing job: '. $current_job);

            return self::SUCCESS;
        }

    }

    /**
     * @param  array<mixed>|bool|string|null  $input
     */
    private function normaliseUserInput(array|bool|string|null $input): ?string
    {
        if (is_array($input)) {
            $input = $input[0] ?? null;
        }

        if (is_bool($input)) {
            $input = null;
        }

        return is_string($input) ? $input : null;
    }
}
