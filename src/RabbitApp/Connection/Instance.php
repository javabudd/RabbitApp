<?php

namespace RabbitApp\Connection;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class Instance extends AMQPStreamConnection
{
    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $config = $this->getConfig();

        parent::__construct($config['url'], $config['port'], $config['rabbitmquser'], $config['rabbitmqpass']);
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getConfig()
    {
        $config = parse_ini_file(BASE_PATH . '/config.ini');
        if (false === $config) {
            throw new \Exception('Unable to parse or find config file');
        }

        return $config;
    }
}