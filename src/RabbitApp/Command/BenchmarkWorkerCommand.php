<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use RabbitApp\Worker\BenchmarkWorker;

/**
 * Class BenchmarkWorkerCommand
 * @package RabbitApp\Command
 */
class BenchmarkWorkerCommand extends Command
{
    public function execute()
    {
        /** @var BenchmarkWorker $benchmark_worker */
        $benchmark_worker = RabbitDi::get(BenchmarkWorker::class);
        $benchmark_worker->setQueueName('benchmark_queue');
        $this->logger->info('Benchmark worker thread started. Stop the worker with CTRL+C');
        $benchmark_worker->run();
    }
}