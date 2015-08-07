<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use RabbitApp\Publisher\JobPublisher;

/**
 * Class BenchmarkCommand
 * @package RabbitApp\Command
 */
class BenchmarkCommand extends Command
{
    public function execute()
    {
        /** @var JobPublisher $publisher */
        $publisher = RabbitDi::get(JobPublisher::class);
        $publisher->setQueueName('benchmark_queue');
        $publisher->publish(['for i in `seq 1 100`; do echo $i^6 | bc; done']);
    }
}