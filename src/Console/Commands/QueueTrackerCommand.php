<?php

namespace Mpstr24\QueueTracker\Console\Commands;

use Illuminate\Console\Command;

class QueueTrackerCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:track {--queue=default}';

    protected $description = 'This command will display the current job in the selected queue.';

    public function handle(): int
    {
        $queue = $this->option('queue');
    }
}
