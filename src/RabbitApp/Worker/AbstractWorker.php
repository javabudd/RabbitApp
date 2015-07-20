<?php

namespace RabbitApp\Worker;

use PhpAmqpLib\Channel\AMQPChannel;
use RabbitApp\Connection\RabbitConnection;

/**
 * Class AbstractWorker
 * @package RabbitApp\Worker
 */
abstract class AbstractWorker
{
    /** @var RabbitConnection */
    protected $rabbit_connection;

    /** @var string */
    protected $queue_name = 'default_queue';

    /** @var null|int */
    protected $channel_id;

    /**
     * @param RabbitConnection $rabbit_connection
     */
    public function __construct(RabbitConnection $rabbit_connection)
    {
        $this->rabbit_connection = $rabbit_connection;
    }

    /**
     * @return callable
     */
    abstract public function callback();

    public function run()
    {
        /** @var AMQPChannel $channel */
        $channel = $this->getChannel();
        $this->declareQueue($channel);
        $consumer_tag = $this->consume($channel);
        echo 'Worker Tag: ' . $consumer_tag . PHP_EOL;
        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel()
    {
        return $this->rabbit_connection->channel($this->channel_id);
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
     * @return mixed
     */
    public function consume(AMQPChannel $channel)
    {
        return $channel->basic_consume(
            $this->queue_name, '', false, true, false, false, $this->callback()
        );
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