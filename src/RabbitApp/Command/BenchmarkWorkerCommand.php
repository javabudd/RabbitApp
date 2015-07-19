<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\Worker\BenchmarkWorker;

class BenchmarkWorkerCommand extends Command
{
    /**
     * @Inject
     *
     * @var BenchmarkWorker
     */
    protected $benchmark_worker;

    public function execute()
    {
        // Create a worker and run
        $this->logger->info('Worker thread started. Stop the worker with CTRL+C');
        $this->benchmark_worker->run();
    }
}