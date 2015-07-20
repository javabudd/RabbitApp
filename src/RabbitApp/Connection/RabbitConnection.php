<?php

namespace RabbitApp\Connection;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;

/**
 * Class RabbitConnection
 * @package RabbitApp\Connection
 */
class RabbitConnection extends AMQPStreamConnection
{
    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $config = $this->getConfig();

        try {
            parent::__construct($config['url'], $config['port'], $config['rabbitmquser'], $config['rabbitmqpass']);
        } catch (AMQPRuntimeException $exception) {
            echo $exception->getMessage();
        }
    }

    public function __destruct()
    {
        $this->close();
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getConfig()
    {
        $config = parse_ini_file(BASE_PATH . '/config/config.ini');
        if (false === $config) {
            throw new \Exception('Unable to parse or find config file');
        }

        return $config;
    }
}