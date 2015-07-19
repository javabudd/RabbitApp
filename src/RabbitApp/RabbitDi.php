<?php

namespace RabbitApp;

use Pimple\Container;
use RabbitApp\Connection\Instance;
use RabbitApp\Publisher\BenchmarkPublisher;
use RabbitApp\Worker\BenchmarkWorker;

class RabbitDi
{
    /**
     * @return Container
     */
    public static function getContainer()
    {
        $container = new Container();

        // Connection
        $container[Instance::class] = function() {
            return new Instance();
        };

        // Worker
        $container[BenchmarkWorker::class] = function($c) {
            return new BenchmarkWorker($c[Instance::class]);
        };

        // Publisher
        $container[BenchmarkPublisher::class] = function($c) {
            return new BenchmarkPublisher($c[Instance::class]);
        };


        return $container;
    }
}