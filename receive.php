<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;

$connection = new AMQPConnection('oddjob.kush.dev', 5672, 'mqadmin', 'mqadmin');
$channel = $connection->channel();

$channel->queue_declare('exec_queue', false, false, false, false);

/** @var PhpAmqpLib\Message\AMQPMessage $msg */
$callback = function($msg) {
    exec($msg->body, $output);
};

$channel->basic_consume('exec_queue', '', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}