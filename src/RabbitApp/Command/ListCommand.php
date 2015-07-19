<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\Connection\Instance;

class ListCommand extends Command
{
    /** @var Instance $instance*/
    protected $connection_instance;

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
        $logger = $this->logger;

        $logger->info('execute');
        $logger->error('error');

        $this->brief();
    }

    public function brief()
    {
        return 'Available jobs to run: LS';
    }
}