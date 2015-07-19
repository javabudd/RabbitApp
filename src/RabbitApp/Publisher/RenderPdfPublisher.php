<?php

namespace RabbitApp\Publisher;

use PhpAmqpLib\Channel\AMQPChannel;

class RenderPdfPublisher extends AbstractPublisher
{
    const RENDER_PDF_QUEUE = 'render_pdf_queue';

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

        // Publish the job
        $channel->basic_publish(
            $this->message->setBody(json_encode($body)), '', self::RENDER_PDF_QUEUE
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
        $channel->queue_declare(self::RENDER_PDF_QUEUE, false, false, false, false);
    }

    /**
     * @param AMQPChannel $channel
     */
    public function closeConnection(AMQPChannel $channel)
    {
        $channel->close();
    }
}