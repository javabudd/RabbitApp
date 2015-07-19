<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitApp\Connection\Instance;
use RabbitApp\Connection\Channel;

class BenchmarkCommand extends Command
{
    public function execute()
    {
        $this->publishJob();

        $this->logger->info('Job published successfully!');
    }

    protected function publishJob()
    {
        // Create connection instance
        $connection_instance = new Instance();

        // Get the Channel object
        $channel = $connection_instance->channel(Channel::$channels[self::class]);

        //Declare queue if it doesn't exist
        $this->declareQueue($channel);

        // Get the Message object and publish job
        $min     = 10000000000000000000;
        $max     = 20000000000000000000;
        $message =
            new AMQPMessage('for i in `seq 1 100`; do echo $i^6 | bc; done', ['message_id' => mt_rand($min, $max)]);
        $channel->basic_publish($message, '', 'exec_queue');

        // Close connections
        $this->closeConnections($connection_instance, $channel);
    }

    protected function declareQueue($channel)
    {
        $channel->queue_declare('exec_queue', false, false, false, false);
    }

    protected function closeConnections($connection_instance, $channel)
    {
        $channel->close();
        $connection_instance->close();
    }
}