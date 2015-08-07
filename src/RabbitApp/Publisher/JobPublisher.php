<?php

namespace RabbitApp\Publisher;

use RabbitApp\Connection\RabbitConnection;

/**
 * Class JobPublisher
 * @package RabbitApp\Publisher
 */
class JobPublisher implements PublisherInterface
{
    /** @var RabbitConnection */
    protected $rabbit_connection;

    /**
     * @param RabbitConnection $rabbit_connection
     */
    public function __construct(RabbitConnection $rabbit_connection)
    {
        $this->rabbit_connection = $rabbit_connection;
    }

    /**
     * @param array $body
     * @return bool
     */
    public function publish(array $body)
    {
        // Declare the queue
        $this->rabbit_connection->declareQueue();

        // Publish the job
        $this->rabbit_connection->basicPublish($body);
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