<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use RabbitApp\Publisher\JobPublisher;
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
            /** @var JobPublisher $publisher */
            $publisher = RabbitDi::get(JobPublisher::class);
            $publisher->setQueueName('render_pdf_queue');
            $publisher->publish(['profile_id' => $profile_id, 'profile_type' => $profile_type]);
            $this->logger->info('Job published successfully!');
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Job failed.');
        }
    }
}