<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\Connection\Instance;
use RabbitApp\Worker\LSWorker;

class LSWorkerCommand extends Command
{
    /**
     * @param Instance $connection_instance
     */
    public function __construct(Instance $connection_instance)
    {
        $this->connection_instance = $connection_instance;

        parent::__construct();
    }

    /**
     * @param $arg1
     * @param $arg2
     * @param int $arg3
     */
    public function execute($arg1,$arg2,$arg3 = 0)
    {
        /** @var \CliFramework\Logger $logger */
        $logger = $this->logger;

        $logger->info('execute');
        $logger->error('error');

        // Create a worker
        $worker = new LSWorker($this->connection_instance);
        $worker->run();
    }
}