<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use RabbitApp\Publisher\RenderPdfPublisher;
use PhpAmqpLib\Exception\AMQPRuntimeException;

/**
 * Class RenderPdfCommand
 * @package RabbitApp\Command
 */
class RenderPdfCommand extends Command
{
    /**
     * @param \CLIFramework\ArgInfoList $args
     */
    public function arguments($args) {
        $args->add('profile_id')
             ->isa('number');

        $args->add('profile_type')
             ->validValues(['1','0']);
    }

    /**
     * @param $profile_id
     * @param $profile_type
     * @throws \Exception
     */
    public function execute($profile_id, $profile_type)
    {
        try {
            /** @var RenderPdfPublisher $render_pdf_publisher */
            $render_pdf_publisher = RabbitDi::get(RenderPdfPublisher::class);
            $render_pdf_publisher->publish(['profile_id' => $profile_id, 'profile_type' => $profile_type]);
            $this->logger->info('Job published successfully!');
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Job failed.');
        }
    }
}