<?php

namespace RabbitApp\Connection;

use RabbitApp\Command\BenchmarkCommand;
use RabbitApp\Worker\BenchmarkWorker;

class Channel
{
    public static $channels = [
        BenchmarkCommand::class => 1,
        BenchmarkWorker::class  => 1
    ];
}