<?php

namespace RabbitApp\Connection\Factory;

use RabbitApp\Publisher\BenchmarkPublisher;
use RabbitApp\Worker\BenchmarkWorker;
use RabbitApp\Connection\InstanceConnection;
use RabbitApp\Publisher\RenderPdfPublisher;
use RabbitApp\Worker\RenderPdfWorker;

class ChannelFactory
{
    /**
     * Channels must be in pairs of Publisher-Worker
     *
     * @var array
     */
    public static $channels = [
        BenchmarkPublisher::class => 1,
        BenchmarkWorker::class    => 1,
        RenderPdfPublisher::class => 2,
        RenderPdfWorker::class    => 2
    ];

    /** @var InstanceConnection */
    protected $connection_instance;

    /**
     * @param InstanceConnection $connection_instance
     */
    public function __construct(InstanceConnection $connection_instance)
    {
        $this->connection_instance = $connection_instance;
    }

    /**
     * @param $class_name
     * @return null|\PhpAmqpLib\Channel\AMQPChannel
     * @throws \Exception
     */
    public function getChannelByClassName($class_name)
    {
        if (array_key_exists($class_name, self::$channels)) {
            $channel = $this->connection_instance->channel(self::$channels[$class_name]);
        } else {
            throw new \Exception(sprintf('Channel key %s not found in channels array', $class_name));
        }

        return $channel;
    }
}