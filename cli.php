<?php

require_once 'vendor/autoload.php';

define('BASE_PATH', __DIR__);

$builder = new \DI\ContainerBuilder();
$builder->useAnnotations(true);
$builder->useAutowiring(false);
$builder->addDefinitions(BASE_PATH .'/config/di.config.php');

$container = $builder->build();
$container->call(function() {
    $app = new RabbitApp\RabbitCli();
    $app->run(['cli.php', 'benchmark-worker']);
});