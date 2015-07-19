<?php

namespace RabbitApp\Worker;

use PhpAmqpLib\Channel\AMQPChannel;
use RabbitApp\Publisher\RenderPdfPublisher;

class RenderPdfWorker extends AbstractWorker
{
    /**
     * @param AMQPChannel $channel
     * @return mixed|string
     */
    public function consume(AMQPChannel $channel)
    {
        return $channel->basic_consume(
            RenderPdfPublisher::RENDER_PDF_QUEUE, '', false, true, false, false, $this->callback()
        );
    }

    public function callback()
    {
        /** @var \PhpAmqpLib\Message\AMQPMessage $args */
        return function($args) {
            $profile_info = implode(',', json_decode($args->body, true));
            echo(date('Y/m/d H:i:s') . ": Profile info: {$profile_info}" . PHP_EOL);
        };
    }

    /**
     * @param AMQPChannel $channel
     */
    public function declareQueue(AMQPChannel $channel)
    {
        $channel->queue_declare(RenderPdfPublisher::RENDER_PDF_QUEUE, false, false, false, false);
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