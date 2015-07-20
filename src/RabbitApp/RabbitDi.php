<?php

namespace RabbitApp;

use Pimple\Container;
use RabbitApp\Connection\RabbitConnection;
use RabbitApp\Message\RabbitMessage;
use RabbitApp\Publisher\JobPublisher;
use RabbitApp\Worker\BenchmarkWorker;
use RabbitApp\Worker\LendingClubWorker;
use RabbitApp\Worker\RenderPdfWorker;

/**
 * Class RabbitDi
 * @package RabbitApp
 */
class RabbitDi
{
    /**
     * @return Container
     * @throws \Exception
     */
    protected function getContainer()
    {
        $container = new Container();

        // Connection
        $container[RabbitConnection::class] = function() {
            return new RabbitConnection();
        };

        // Message
        $container[RabbitMessage::class] = function($c) {
            return new RabbitMessage('', $c['rabbit_properties']);
        };

        // Publisher
        $container[JobPublisher::class] = function($c) {
            return new JobPublisher($c[RabbitConnection::class], $c[RabbitMessage::class]);
        };

        // Properties
        $container['rabbit_properties'] = function() {
            return ['message_id' => time()];
        };

        // Workers
        $container[BenchmarkWorker::class] = function($c) {
            return new BenchmarkWorker($c[RabbitConnection::class]);
        };
        $container[RenderPdfWorker::class] = function($c) {
            return new RenderPdfWorker($c[RabbitConnection::class]);
        };
        $container[LendingClubWorker::class] = function($c) {
            return new LendingClubWorker($c[RabbitConnection::class]);
        };


        return $container;
    }

    /**
     * Method for retrieving a class from the container based on class name.
     *
     * @param $class_name
     * @return mixed
     * @throws \Exception
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