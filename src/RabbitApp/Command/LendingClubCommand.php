<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\Publisher\JobPublisher;
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
        /** @var JobPublisher $publisher */
        $publisher = RabbitDi::get(JobPublisher::class);
        $publisher->setQueueName('lending_club_queue');
        $publisher->publish([$api_key]);
    }
}