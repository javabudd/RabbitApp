<?php

namespace RabbitApp\Worker;

use Httpful\Request;
use PhpAmqpLib\Channel\AMQPChannel;
use RabbitApp\Publisher\LendingClubPublisher;

/**
 * Class LendingClubWorker
 * @package RabbitApp\Worker
 */
class LendingClubWorker extends AbstractWorker
{
    /**
     * @param AMQPChannel $channel
     * @return mixed|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function consume(AMQPChannel $channel)
    {
        return $channel->basic_consume(
            LendingClubPublisher::LENDING_CLUB_QUEUE, '', false, true, false, false, $this->callback()
        );
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
     * Call LendingClub and gather all loans
     *
     * @return callable
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function callback()
    {
        $uri = 'https://api.lendingclub.com/api/investor/1/loans/listing';
        /** @var \PhpAmqpLib\Message\AMQPMessage $args */
        return function($args) use($uri) {
            $request = Request::init('GET');
            $request->uri($uri);
            $request->addHeader('Accept', 'application/json');
            $request->addHeader('Content-Type', 'application/json');
            $request->addHeader('Authorization', $args->body);
            /** @var \Httpful\Response $response */
            $response = $request->send();

            // Perform DB operation with response
        };
    }

    /**
     * @param AMQPChannel $channel
     */
    public function declareQueue(AMQPChannel $channel)
    {
        $channel->queue_declare(LendingClubPublisher::LENDING_CLUB_QUEUE, false, false, false, false);
    }
}