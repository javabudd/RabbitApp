<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\Publisher\BenchmarkPublisher;
use RabbitApp\RabbitDi;


class BenchmarkCommand extends Command
{
    public function execute()
    {
        try {
            $container = RabbitDi::getContainer();
            /** @var \RabbitApp\Publisher\BenchmarkPublisher $benchmark_worker */
            $benchmark_worker = $container[BenchmarkPublisher::class];
            $benchmark_worker->publish();
            $this->logger->info('Job published successfully!');
        } catch (\Exception $e) {
            $this->logger->error('Job failed.');
        }
    }
}