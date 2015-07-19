<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use RabbitApp\RabbitDi;
use RabbitApp\Worker\BenchmarkWorker;

class BenchmarkWorkerCommand extends Command
{
    public function execute()
    {
        try {
            /** @var BenchmarkWorker $benchmark_worker */
            $benchmark_worker = RabbitDi::get(BenchmarkWorker::class);
            $this->logger->info('Benchmark worker thread started. Stop the worker with CTRL+C');
            $benchmark_worker->run();
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Unable to start the worker.');
        }
    }
}