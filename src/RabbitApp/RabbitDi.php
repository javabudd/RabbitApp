<?php

namespace RabbitApp;

use Pimple\Container;
use RabbitApp\Connection\Factory\ChannelFactory;
use RabbitApp\Connection\InstanceConnection;
use RabbitApp\Message\RabbitMessage;
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

        // Connections
        $container[InstanceConnection::class] = function() {
            return new InstanceConnection();
        };
        $container[ChannelFactory::class] = function($c) {
            return new ChannelFactory($c[InstanceConnection::class]);
        };

        // Messages
        $container[RabbitMessage::class] = function($c) {
            return new RabbitMessage('', $c['rabbit_properties']);
        };

        // Publishers
        $container[BenchmarkPublisher::class] = function($c) {
            return new BenchmarkPublisher($c[ChannelFactory::class], $c[RabbitMessage::class]);
        };

        // Properties
        $container['rabbit_properties'] = function() {
            return ['message_id' => time()];
        };

        // Workers
        $container[BenchmarkWorker::class] = function($c) {
            return new BenchmarkWorker($c[ChannelFactory::class]);
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
        try {
            $class = self::getContainer()[$class_name];
        } catch (\InvalidArgumentException $e) {
            die(sprintf('Class %s was not found in the container.', $class_name));
        }

        return $class;
    }
}