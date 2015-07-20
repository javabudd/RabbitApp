<?php

namespace RabbitApp\Publisher;

use PhpAmqpLib\Channel\AMQPChannel;

/**
 * Class BenchmarkPublisher
 * @package RabbitApp\Publisher
 */
class BenchmarkPublisher extends AbstractPublisher
{
    const BENCHMARK_QUEUE = 'benchmark_queue';
    
    /**
     * @param $body
     * @param array $opts
     * @throws \Exception
     */
    public function publish($body, array $opts = [])
    {
        // Get the channel
        $channel = $this->getChannel();

        // Declare the queue
        $this->declareQueue($channel);

        // Publish the job
        $channel->basic_publish(
            $this->message->setBody($body), '', self::BENCHMARK_QUEUE
        );

        // Close the connection
        $this->closeConnection($channel);
    }

    /**
     * @return null|\PhpAmqpLib\Channel\AMQPChannel
     * @throws \Exception
     */
    public function getChannel()
    {
        return $this->channel_factory->getChannelByClassName(self::class);
    }

    /**
     * @param AMQPChannel $channel
     */
    public function declareQueue(AMQPChannel $channel)
    {
        $channel->queue_declare(self::BENCHMARK_QUEUE, false, false, false, false);
    }

    /**
     * @param AMQPChannel $channel
     */
    public function closeConnection(AMQPChannel $channel)
    {
        $channel->close();
    }
}

