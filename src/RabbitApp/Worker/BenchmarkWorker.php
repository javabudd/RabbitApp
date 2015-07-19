<?php

namespace RabbitApp\Worker;

use RabbitApp\Connection\Instance;

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
        while(count($channel->callbacks)) {
            $channel->wait();
        }
    }

    /**
     * @param $channel
     */
    public function consume($channel)
    {
        $channel->basic_consume('exec_queue', '', false, true, false, false, $this->callback());
    }

    /**
     * @return string
     */
    public function callback()
    {
        return 'callback';
    }

    /**
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function getChannel()
    {
        return $this->connection_instance->channel();
    }
}