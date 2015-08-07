<?php

namespace RabbitApp\Publisher;

/**
 * Interface PublisherInterface
 * @package RabbitApp\Publisher
 */
interface PublisherInterface
{
    /**
     * @param $queue_name
     * @return mixed
     */
    public function setQueueName($queue_name);

    /**
     * @param $channel_id
     * @return mixed
     */
    public function setChannelId($channel_id);
}