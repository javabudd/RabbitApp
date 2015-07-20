<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use RabbitApp\Publisher\Publisher;
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
            /** @var Publisher $publisher */
            $publisher = RabbitDi::get(Publisher::class);
            $publisher->setQueueName('render_pdf_queue');
            $publisher->publish(['profile_id' => $profile_id, 'profile_type' => $profile_type]);
            $this->logger->info('Job published successfully!');
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Job failed.');
        }
    }
}