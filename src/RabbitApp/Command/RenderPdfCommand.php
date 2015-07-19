<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use RabbitApp\Publisher\RenderPdfPublisher;
use PhpAmqpLib\Exception\AMQPRuntimeException;

class RenderPdfCommand extends Command
{
    public function execute()
    {
        try {
            /** @var \RabbitApp\Publisher\RenderPdfPublisher $render_pdf_publisher */
            $render_pdf_publisher = RabbitDi::get(RenderPdfPublisher::class);
            $render_pdf_publisher->publish(['profile_id' => 12354, 'profile_type' => 1]);
            $this->logger->info('Job published successfully!');
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Job failed.');
        }
    }
}