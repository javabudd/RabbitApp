<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use RabbitApp\Worker\LendingClubWorker;

/**
 * Class LendingClubWorkerCommand
 * @package RabbitApp\Command
 */
class LendingClubWorkerCommand extends Command
{
    public function execute()
    {
        /** @var LendingClubWorker $lending_club_worker */
        $lending_club_worker = RabbitDi::get(LendingClubWorker::class);
        $lending_club_worker->setQueueName('lending_club_queue');
        $this->logger->info('Lending Club worker thread started. Stop the worker with CTRL+C');
        $lending_club_worker->run();
    }
}