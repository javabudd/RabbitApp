<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;

class BenchmarkCommand extends Command
{
    public function execute()
    {
        try {
            $benchmark_publisher = RabbitDi::getBenchmarkPublisher();
            $benchmark_publisher->publish();
            $this->logger->info('Job published successfully!');
        } catch (\Exception $e) {
            $this->logger->error('Job failed.');
        }
    }
}