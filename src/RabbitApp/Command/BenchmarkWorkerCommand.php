<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use RabbitApp\RabbitDi;

class BenchmarkWorkerCommand extends Command
{
    public function execute()
    {
        try {
            $benchmark_worker = RabbitDi::getBenchmarkWorker();
            $this->logger->info('Worker thread started. Stop the worker with CTRL+C');
            $benchmark_worker->run();
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Unable to start the worker.');
        }
    }
}