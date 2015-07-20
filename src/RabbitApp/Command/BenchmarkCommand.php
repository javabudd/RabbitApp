<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use RabbitApp\Publisher\JobPublisher;
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
            /** @var JobPublisher $publisher */
            $publisher = RabbitDi::get(JobPublisher::class);
            $publisher->setQueueName('benchmark_queue');
            $publisher->publish(['for i in `seq 1 100`; do echo $i^6 | bc; done']);
            $this->logger->info('Job published successfully!');
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Job failed.');
        }
    }
}