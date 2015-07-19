<?php

namespace RabbitApp\Publisher;

use PhpAmqpLib\Channel\AMQPChannel;
use RabbitApp\Connection\Channel;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitApp\Connection\Instance;

class BenchmarkPublisher implements PublisherInterface
{
    /** @var Instance */
    protected $connection_instance;

    /**
     * @param Instance $connection_instance
     */
    public function __construct(Instance $connection_instance)
    {
        $this->connection_instance = $connection_instance;
    }

    public function publish()
    {
        // Get the Channel object
        $channel = $this->connection_instance->channel(Channel::$channels[self::class]);

        //Declare queue if it doesn't exist
        $this->declareQueue($channel);

        // Get the Message object and publish job
        $min     = 10000000000000000000;
        $max     = 20000000000000000000;
        $message =
            new AMQPMessage('for i in `seq 1 100`; do echo $i^6 | bc; done', ['message_id' => mt_rand($min, $max)]);
        $channel->basic_publish($message, '', 'exec_queue');

        // Close connections
        $channel->close();
    }

    /**
     * @param AMQPChannel $channel
     */
    public function declareQueue(AMQPChannel $channel)
    {
        $channel->queue_declare('exec_queue', false, false, false, false);
    }
}