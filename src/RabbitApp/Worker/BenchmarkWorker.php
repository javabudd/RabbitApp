<?php

namespace RabbitApp\Worker;

use RabbitApp\Connection\Factory\ChannelFactory;

class BenchmarkWorker implements WorkerInterface
{
    /** @var ChannelFactory */
    protected $channel_factory;

    /**
     * @param ChannelFactory $channel_factory
     * @throws \Exception
     */
    public function __construct(ChannelFactory $channel_factory)
    {
        $this->channel = $channel_factory->getChannelByClassName(self::class);
    }

    /**
     * @TODO Threading
     *
     * @throws \Exception
     */
    public function run()
    {
        $consumer_tag = $this->consume();
        echo 'Worker Tag: ' . $consumer_tag . PHP_EOL;
        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    /**
     * @return mixed|string
     */
    public function consume()
    {
        return $this->channel->basic_consume('exec_queue', '', false, true, false, false, $this->callback());
    }

    /**
     * @TODO Change this from exec, clean $args->body
     *
     * @return callable
     */
    public function callback()
    {
        /** @var \PhpAmqpLib\Message\AMQPMessage $args */
        return function($args) {
            exec($args->body);
            echo(date('Y/m/d H:i:s') . ": Job #{$args->get('message_id')} finished!" . PHP_EOL);
        };
    }

}