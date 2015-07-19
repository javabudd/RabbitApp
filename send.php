<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$config = parse_ini_file('config.ini');

$connection = new AMQPConnection($config['url'], $config['port'], $config['rabbitmquser'], $config['rabbitmqpass']);
$channel = $connection->channel();

$channel->queue_declare('exec_queue', false, false, false, false);

$msg = new AMQPMessage('for i in `seq 1 100`; do echo $i^6 | bc; done');
$channel->basic_publish($msg, '', 'exec_queue');

$channel->close();
$connection->close();