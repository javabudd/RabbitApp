<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use RabbitApp\Publisher\LendingClubPublisher;
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
            /** @var LendingClubPublisher $lending_club_publisher */
            $lending_club_publisher = RabbitDi::get(LendingClubPublisher::class);
            $lending_club_publisher->publish($api_key, []);
            $this->logger->info('Job published successfully!');
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Job failed.');
        }
    }
}