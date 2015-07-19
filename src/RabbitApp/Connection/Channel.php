<?php

namespace RabbitApp\Connection;

use RabbitApp\Publisher\BenchmarkPublisher;
use RabbitApp\Worker\BenchmarkWorker;

class Channel
{
    public static $channels = [
        BenchmarkPublisher::class => 1,
        BenchmarkWorker::class  => 1
    ];
}