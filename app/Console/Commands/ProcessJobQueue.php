<?php

namespace App\Console\Commands;

use App\Jobs\Worker;
use Illuminate\Console\Command;
use Illuminate\Queue\WorkerOptions;

/**
 * Class ProcessJobQueue
 * @package App\Console\Commands
 */
class ProcessJobQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process-job-queue:run';

    /**
     * Execute the console command.
     *
     * @param Worker $worker
     * @return void
     */
    public function handle(Worker $worker): void
    {
        $workerOptions = new WorkerOptions();
        $workerOptions->stopWhenEmpty = true;
        $worker->daemon('database', 'default', $workerOptions);
    }
}
