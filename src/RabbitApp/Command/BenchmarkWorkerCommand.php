<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\Connection\Instance;
use RabbitApp\Worker\BenchmarkWorker;

class BenchmarkWorkerCommand extends Command
{
    public function execute()
    {
        // Create connection instance
        $connection_instance = new Instance();

        // Create a worker and run
        $worker = new BenchmarkWorker($connection_instance);
        $worker->run();

        $this->logger->info('Worker started');
    }
}