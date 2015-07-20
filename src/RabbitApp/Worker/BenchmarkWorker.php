<?php

namespace RabbitApp\Worker;

use PhpAmqpLib\Channel\AMQPChannel;
use RabbitApp\Publisher\BenchmarkPublisher;

/**
 * Class BenchmarkWorker
 * @package RabbitApp\Worker
 */
class BenchmarkWorker extends AbstractWorker
{
    /**
     * @param AMQPChannel $channel
     * @return mixed
     */
    public function consume(AMQPChannel $channel)
    {
        return $channel->basic_consume(
            BenchmarkPublisher::BENCHMARK_QUEUE, '', false, true, false, false, $this->callback()
        );
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

    /**
     * @param AMQPChannel $channel
     */
    public function declareQueue(AMQPChannel $channel)
    {
        $channel->queue_declare(BenchmarkPublisher::BENCHMARK_QUEUE, false, false, false, false);
    }

    /**
     * @return null|AMQPChannel
     * @throws \Exception
     */
    public function getChannel()
    {
        return $this->channel_factory->getChannelByClassName(self::class);
    }
}