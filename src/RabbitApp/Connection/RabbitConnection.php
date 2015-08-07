<?php

namespace RabbitApp\Connection;

use CLIFramework\Logger;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Channel\AMQPChannel;
use RabbitApp\Message\RabbitMessage;

/**
 * Class RabbitConnection
 * @package RabbitApp\Connection
 */
class RabbitConnection extends AMQPStreamConnection
{
    /** @var RabbitMessage */
    protected $message;

    /** @var Logger */
    protected $logger;

    /** @var int */
    protected $channel_id = 1;

    /** @var string */
    protected $queue_name = 'default_queue';

    /**
     * @param RabbitMessage $message
     * @param Logger $logger
     * @throws \Exception
     */
    public function __construct(RabbitMessage $message, Logger $logger)
    {
        $this->logger  = $logger;
        $this->message = $message;
        $config        = $this->getConfig();
        try {
            parent::__construct($config['url'], $config['port'], $config['rabbitmquser'], $config['rabbitmqpass']);
        } catch (AMQPRuntimeException $e) {
            $this->logger->error($e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->getChannel()->close();
        $this->close();
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getConfig()
    {
        $file = BASE_PATH . '/config/config.ini';
        if (!file_exists($file)) {
            $this->logger->error('Unable to find configuration file.');
        }
        $config = parse_ini_file($file);
        if (false === $config) {
            $this->logger->error('Unable to parse configuration file');
        }

        return $config;
    }

    public function declareQueue()
    {
        try {
            $this->getChannel()->queue_declare($this->queue_name, false, false, false, false);
        } catch (\AMQPQueueException $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @param $body
     */
    public function basicPublish($body)
    {
        try {
            $this->getChannel()->basic_publish($this->message->setBody(json_encode($body)), '', $this->queue_name);
            $this->logger->info('Job published successfully!');
        } catch (\AMQPChannelException $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @param $callback
     * @return mixed
     */
    public function basicConsume($callback)
    {
        return $this->getChannel()->basic_consume(
            $this->queue_name, '', false, true, false, false, $callback
        );
    }

    /**
     * @return AMQPChannel
     */
    public function getChannel()
    {
        return $this->channel($this->channel_id);
    }

    /**
     * @param $channel_id
     * @return RabbitConnection
     */
    public function setChannelId($channel_id)
    {
        $this->channel_id = (int)$channel_id;

        return $this;
    }

    /**
     * @param $queue_name
     * @return RabbitConnection
     */
    public function setQueueName($queue_name)
    {
        $this->queue_name = (string)$queue_name;

        return $this;
    }
}