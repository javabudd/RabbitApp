<?php

namespace RabbitApp\Worker;

/**
 * Class RenderPdfWorker
 * @package RabbitApp\Worker
 */
class RenderPdfWorker extends AbstractWorker
{
    /**
     * @return callable
     */
    public function callback()
    {
        /** @var \PhpAmqpLib\Message\AMQPMessage $args */
        return function($args) {
            $profile_info = implode(',', json_decode($args->body, true));
            echo(date('Y/m/d H:i:s') . ": Profile info: {$profile_info}" . PHP_EOL);
        };
    }
}