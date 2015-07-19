<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use RabbitApp\Publisher\BenchmarkPublisher;
use PhpAmqpLib\Exception\AMQPRuntimeException;

class BenchmarkCommand extends Command
{
    public function execute()
    {
        try {
            /** @var BenchmarkPublisher $benchmark_publisher */
            $benchmark_publisher = RabbitDi::get(BenchmarkPublisher::class);
            $benchmark_publisher->publish();
            $this->logger->info('Job published successfully!');
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Job failed.');
        }
    }
}