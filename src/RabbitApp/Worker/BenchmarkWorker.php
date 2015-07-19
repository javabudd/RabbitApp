<?php

namespace RabbitApp\Worker;

use RabbitApp\Connection\Instance;
use PhpAmqpLib\Channel\AMQPChannel;
use RabbitApp\Connection\Channel;

class BenchmarkWorker implements WorkerInterface
{
    /** @var Instance */
    protected $connection_instance;

    /**
     * @param Instance $connection_instance
     */
    public function __construct(Instance $connection_instance)
    {
        $this->connection_instance = $connection_instance;
    }

    /**
     * @TODO Threading
     */
    public function run()
    {
        $channel = $this->getChannel();
        $this->consume($channel);
        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }

    /**
     * @param AMQPChannel $channel
     */
    public function consume(AMQPChannel $channel)
    {
        $channel->basic_consume('exec_queue', '', false, true, false, false, $this->callback());
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
            exec($args->body, $out);
            var_dump($out);
            echo(PHP_EOL . 'Job finished!');
        };
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel()
    {
        return $this->connection_instance->channel(Channel::$channels[self::class]);
    }
}