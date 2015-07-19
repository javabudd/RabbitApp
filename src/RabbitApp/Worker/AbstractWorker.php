<?php

namespace RabbitApp\Worker;

use PhpAmqpLib\Channel\AMQPChannel;
use RabbitApp\Connection\Factory\ChannelFactory;

abstract class AbstractWorker
{
    /** @var ChannelFactory */
    protected $channel_factory;

    /**
     * @param ChannelFactory $channel_factory
     */
    public function __construct(ChannelFactory $channel_factory)
    {
        $this->channel_factory = $channel_factory;
    }

    public function run()
    {
        /** @var \PhpAmqpLib\Channel\AMQPChannel $channel */
        $channel      = $this->getChannel();
        $this->declareQueue($channel);
        $consumer_tag = $this->consume($channel);
        echo 'Worker Tag: ' . $consumer_tag . PHP_EOL;
        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }

    abstract public function consume(AMQPChannel $channel);

    abstract public function callback();

    abstract public function getChannel();

    abstract public function declareQueue(AMQPChannel $channel);
}