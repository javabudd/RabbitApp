<?php

namespace RabbitApp\Publisher;

use RabbitApp\Connection\InstanceConnection;
use RabbitApp\Message\RabbitMessage;
use PhpAmqpLib\Channel\AMQPChannel;

/**
 * Class Publisher
 * @package RabbitApp\Publisher
 */
class Publisher
{
    /** @var InstanceConnection */
    protected $instance_connection;

    /** @var RabbitMessage */
    protected $message;

    /** @var string */
    protected $queue_name = 'default_queue';

    /** @var null|int */
    protected $channel_id;

    /**
     * @param InstanceConnection $instance_connection
     * @param RabbitMessage $message
     */
    public function __construct(InstanceConnection $instance_connection, RabbitMessage $message)
    {
        $this->instance_connection = $instance_connection;
        $this->message             = $message;
    }

    /**
     * @param array $body
     * @param array $opts
     */
    public function publish(array $body, array $opts = [])
    {
        // Get the channel
        /** @var AMQPChannel $channel */
        $channel = $this->getChannel();

        // Declare the queue
        $this->declareQueue($channel);

        // Publish the job
        $channel->basic_publish(
            $this->message->setBody(json_encode($body)), '', $this->queue_name
        );

        // Close the connection
        $this->closeConnection($channel);
    }

    /**
     * @param AMQPChannel $channel
     */
    public function declareQueue(AMQPChannel $channel)
    {
        $channel->queue_declare($this->queue_name, false, false, false, false);
    }

    /**
     * @param AMQPChannel $channel
     */
    public function closeConnection(AMQPChannel $channel)
    {
        $channel->close();
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel()
    {
        return $this->instance_connection->channel($this->channel_id);
    }

    /**
     * @param $channel_id
     * @return $this
     */
    public function setChannelId($channel_id)
    {
        $this->channel_id = (int)$channel_id;

        return $this;
    }

    /**
     * @param $queue_name
     * @return $this
     */
    public function setQueueName($queue_name)
    {
        $this->queue_name = (string)$queue_name;

        return $this;
    }
}