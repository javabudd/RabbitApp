<?php

namespace RabbitApp\Worker;

/**
 * Interface WorkerInterface
 * @package RabbitApp\Worker
 */
interface WorkerInterface
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