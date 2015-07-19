<?php

namespace RabbitApp\Worker;

use PhpAmqpLib\Channel\AMQPChannel;

interface WorkerInterface
{
    public function run();

    public function consume(AMQPChannel $channel);

    public function callback();

    public function getChannel();
}