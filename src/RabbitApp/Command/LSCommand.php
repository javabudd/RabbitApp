<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitApp\Connection\Instance;

class LSCommand extends Command
{
    /** @var Instance */
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
        /** @var \CliFramework\Logger $logger */
        $logger = $this->logger;

        $logger->info('execute');
        $logger->error('error');

        $this->publishJob();
    }

    protected function publishJob()
    {
        // Get the Channel object
        $channel = $this->connection_instance->channel();

        //Declare queue if it doesn't exist
        $this->declareQueue($channel);

        // Get the Message object and publish job
        $message = new AMQPMessage('for i in `seq 1 100`; do echo $i^6 | bc; done');
        $channel->basic_publish($message, '', 'exec_queue');

        // Close connections
        $this->closeConnections($channel);
    }

    protected function declareQueue($channel)
    {
        $channel->queue_declare('exec_queue', false, false, false, false);
    }

    protected function closeConnections($channel)
    {
        $this->connection_instance->close();
        $channel->close();
    }
}