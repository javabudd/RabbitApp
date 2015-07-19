<?php

namespace RabbitApp\Command;

use CLIFramework\Command;

class ListCommand extends Command
{
    public function execute()
    {
        $this->logger->info('Available jobs to run: benchmark');
    }
}