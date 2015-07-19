<?php

require_once 'vendor/autoload.php';

define('BASE_PATH', __DIR__);

// Dispatch
$app = new RabbitApp\RabbitCli();
$app->run($argv);