<?php

namespace RabbitApp\Command;

use CLIFramework\Command;

/**
 * Class ListCommand
 * @package RabbitApp\Command
 */
class ListCommand extends Command
{
    public function execute()
    {
        $this->logger->info('Available jobs to run: benchmark, benchmark-worker');
    }
}