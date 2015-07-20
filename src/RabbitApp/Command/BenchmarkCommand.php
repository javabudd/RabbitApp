<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use RabbitApp\Publisher\Publisher;
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
            /** @var Publisher $publisher */
            $publisher = RabbitDi::get(Publisher::class);
            $publisher->setQueueName('benchmark_queue');
            $publisher->publish(['for i in `seq 1 100`; do echo $i^6 | bc; done']);
            $this->logger->info('Job published successfully!');
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Job failed.');
        }
    }
}