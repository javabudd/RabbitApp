<?php

namespace RabbitApp\Publisher;

use RabbitApp\Connection\Factory\ChannelFactory;
use RabbitApp\Message\RabbitMessage;

class BenchmarkPublisher implements PublisherInterface
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
        $this->channel = $channel_factory->getChannelByClassName(self::class);
        $this->message = $message;
    }

    public function publish()
    {
        // Publish the job
        $this->channel->basic_publish(
            $this->message->setBody('for i in `seq 1 100`; do echo $i^6 | bc; done'), '', 'exec_queue'
        );

        // Close connections
        $this->channel->close();
    }
}

