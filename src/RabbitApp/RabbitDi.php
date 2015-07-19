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

    /**
     * Method for retrieving a class from the container based on class name.
     *
     * @param $class_name
     * @return mixed
     */
    public static function get($class_name)
    {
        return self::getContainer()[$class_name];
    }
}