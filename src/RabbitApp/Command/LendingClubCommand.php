<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use RabbitApp\Publisher\Publisher;
use RabbitApp\RabbitDi;

/**
 * Class LendingClubCommand
 * @package RabbitApp\Command
 */
class LendingClubCommand extends Command
{
    /**
     * @param \CLIFramework\ArgInfoList $args
     */
    public function arguments($args)
    {
        $args->add('api_key')
             ->isa('string');
    }

    /**
     * @param $api_key
     * @throws \Exception
     */
    public function execute($api_key)
    {
        try {
            /** @var Publisher $publisher */
            $publisher = RabbitDi::get(Publisher::class);
            $publisher->setQueueName('lending_club_queue');
            $publisher->publish([$api_key]);
            $this->logger->info('Job published successfully!');
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Job failed.');
        }
    }
}