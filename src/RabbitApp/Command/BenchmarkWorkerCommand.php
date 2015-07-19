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
            $container = RabbitDi::getContainer();
            /** @var BenchmarkWorker $benchmark_worker */
            $benchmark_worker = $container[BenchmarkWorker::class];
            $this->logger->info('Worker thread started. Stop the worker with CTRL+C');
            $benchmark_worker->run();
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Unable to start the worker.');
        }
    }
}