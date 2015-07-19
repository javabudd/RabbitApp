<?php

require_once 'vendor/autoload.php';

define('BASE_PATH', __DIR__);

$app = new RabbitApp\RabbitCli();
$app->run($argv);