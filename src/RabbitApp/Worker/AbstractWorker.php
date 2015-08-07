<?php

namespace RabbitApp\Worker;

use RabbitApp\Connection\RabbitConnection;

/**
 * Class AbstractWorker
 * @package RabbitApp\Worker
 */
abstract class AbstractWorker implements WorkerInterface
{
    /** @var RabbitConnection */
    protected $rabbit_connection;

    /** @var string */
    protected $queue_name = 'default_queue';

    /** @var null|int */
    protected $channel_id;

    /**
     * @return callable
     */
    abstract public function callback();

    /**
     * @param RabbitConnection $rabbit_connection
     */
    public function __construct(RabbitConnection $rabbit_connection)
    {
        $this->rabbit_connection = $rabbit_connection;
    }

    public function run()
    {
        // Declare queue
        $this->rabbit_connection->declareQueue();

        // Consume the job
        $consumer_tag = $this->rabbit_connection->basicConsume($this->callback());

        echo 'Worker Tag: ' . $consumer_tag . PHP_EOL;
        while (count($this->rabbit_connection->getChannel()->callbacks)) {
            $this->rabbit_connection->getChannel()->wait();
        }
    }

    /**
     * @param $queue_name
     * @return RabbitConnection
     */
    public function setQueueName($queue_name)
    {
        return $this->rabbit_connection->setQueueName($queue_name);
    }

    /**
     * @param $channel_id
     * @return RabbitConnection
     */
    public function setChannelId($channel_id)
    {
        return $this->rabbit_connection->setChannelId($channel_id);
    }
}