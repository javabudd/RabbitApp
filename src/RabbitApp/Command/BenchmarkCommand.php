<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use RabbitApp\Publisher\BenchmarkPublisher;
use PhpAmqpLib\Exception\AMQPRuntimeException;

/**
 * Class BenchmarkCommand
 * @package RabbitApp\Command
 */
class BenchmarkCommand extends Command
{
    public function execute()
    {
        try {
            /** @var BenchmarkPublisher $benchmark_publisher */
            $benchmark_publisher = RabbitDi::get(BenchmarkPublisher::class);
            $benchmark_publisher->publish('for i in `seq 1 100`; do echo $i^6 | bc; done');
            $this->logger->info('Job published successfully!');
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Job failed.');
        }
    }
}