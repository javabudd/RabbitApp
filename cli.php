<?php

require_once 'vendor/autoload.php';

define('BASE_PATH', __DIR__);

$builder = new \DI\ContainerBuilder();
$builder->useAnnotations(true);
$builder->useAutowiring(false);
$builder->addDefinitions(BASE_PATH .'/config/di.config.php');

$container = $builder->build();
$container->call(startRabbitCli($argv));

/**
 * @param array $argv
 * @return callable
 */
function startRabbitCli(array $argv)
{
    return function() use ($argv) {
        $app = new RabbitApp\RabbitCli();
        $app->run($argv);
    };
}