<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPConnection('oddjob.kush.dev', 5672, 'mqadmin', 'mqadmin');
$channel = $connection->channel();

$channel->queue_declare('exec_queue', false, false, false, false);

$msg = new AMQPMessage('ls -la');
$channel->basic_publish($msg, '', 'exec_queue');

$channel->close();
$connection->close();