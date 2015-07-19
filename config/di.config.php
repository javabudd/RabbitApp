<?php

use Interop\Container\ContainerInterface;

return [
    // Connection
    \RabbitApp\Connection\Instance::class => function(ContainerInterface $c) {
        return new \RabbitApp\Connection\Instance();
    },

    // Worker
    \RabbitApp\Worker\BenchmarkWorker::class => function (ContainerInterface $c) {
        return new \RabbitApp\Worker\BenchmarkWorker($c->get(\RabbitApp\Connection\Instance::class));
    }
];