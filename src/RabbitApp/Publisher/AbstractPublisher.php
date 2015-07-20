<?php

namespace RabbitApp\Publisher;

use RabbitApp\Connection\Factory\ChannelFactory;
use RabbitApp\Message\RabbitMessage;
use PhpAmqpLib\Channel\AMQPChannel;

/**
 * Class AbstractPublisher
 * @package RabbitApp\Publisher
 */
abstract class AbstractPublisher
{
    /** @var ChannelFactory */
    protected $channel_factory;

    /** @var RabbitMessage */
    protected $message;

    /**
     * @param ChannelFactory $channel_factory
     * @param RabbitMessage $message
     * @throws \Exception
     */
    public function __construct(ChannelFactory $channel_factory, RabbitMessage $message)
    {
        $this->channel_factory = $channel_factory;
        $this->message         = $message;
    }

    abstract public function publish($body, array $opts = []);

    abstract public function getChannel();

    abstract public function declareQueue(AMQPChannel $channel);

    abstract public function closeConnection(AMQPChannel $channel);
}