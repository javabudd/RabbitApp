<?php

namespace RabbitApp\Worker;

/**
 * Class BenchmarkWorker
 * @package RabbitApp\Worker
 */
class BenchmarkWorker extends AbstractWorker
{
    /**
     * @TODO Change this from exec, clean $args->body
     *
     * @return callable
     */
    public function callback()
    {
        /** @var \PhpAmqpLib\Message\AMQPMessage $args */
        return function($args) {
            $command = json_decode($args->body)[0];
            exec($command);
            echo(date('Y/m/d H:i:s') . ": Job #{$args->get('message_id')} finished!" . PHP_EOL);
        };
    }
}