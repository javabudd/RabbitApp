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
    protected function getContainer()
    {
        $container = new Container();

        // Connection
        $container[Instance::class] = function() {
            return new Instance();
        };

        // Workers
        $container[BenchmarkWorker::class] = function($c) {
            return new BenchmarkWorker($c[Instance::class]);
        };

        // Publishers
        $container[BenchmarkPublisher::class] = function($c) {
            return new BenchmarkPublisher($c[Instance::class]);
        };


        return $container;
    }

    // Callable Workers
    /**
     * @return BenchmarkWorker
     */
    public static function getBenchmarkWorker()
    {
        return self::getContainer()[BenchmarkWorker::class];
    }

    // Callable Publishers
    /**
     * @return BenchmarkPublisher
     */
    public static function getBenchmarkPublisher()
    {
        return self::getContainer()[BenchmarkPublisher::class];
    }
}