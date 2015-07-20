<?php

namespace RabbitApp\Publisher;

use PhpAmqpLib\Channel\AMQPChannel;

/**
 * Class LendingClubPublisher
 * @package RabbitApp\Publisher
 */
class LendingClubPublisher extends AbstractPublisher
{
    const LENDING_CLUB_QUEUE = 'lending_club_queue';

    /**
     * @param $body
     * @param array $opts
     * @throws \Exception
     */
    public function publish($body, array $opts = [])
    {
        // Get the channel
        $channel = $this->getChannel();

        // Declare queue
        $this->declareQueue($channel);

        // Publish job
        $channel->basic_publish(
            $this->message->setBody($body), '', self::LENDING_CLUB_QUEUE
        );

        // Close connection
        $this->closeConnection($channel);
    }

    /**
     * @return null|AMQPChannel
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
        $channel->queue_declare(self::LENDING_CLUB_QUEUE, false, false, false, false);
    }

    /**
     * @param AMQPChannel $channel
     */
    public function closeConnection(AMQPChannel $channel)
    {
        $channel->close();
    }
}