<?php

namespace RabbitApp\Publisher;

use PhpAmqpLib\Channel\AMQPChannel;

interface PublisherInterface
{
    public function publish();

    public function declareQueue(AMQPChannel $channel);
}