<?php

namespace RabbitApp;

use CLIFramework\Application;

/**
 * Class RabbitCli
 * @package RabbitApp
 */
class RabbitCli extends Application
{
    public function init()
    {
        $this->command('list', '\RabbitApp\Command\ListCommand');

        // Commands/Publishers
        $this->commandGroup('Publishers', [
            'benchmark'    => 'RabbitApp\Command\BenchmarkCommand',
            'render-pdf'   => 'RabbitApp\Command\RenderPdfCommand',
            'lending-club' => 'RabbitApp\Command\LendingClubCommand'
        ]);

        // Workers
        $this->commandGroup('Workers', [
            'benchmark-worker'    => 'RabbitApp\Command\BenchmarkWorkerCommand',
            'render-pdf-worker'   => 'RabbitApp\Command\RenderPdfWorkerCommand',
            'lending-club-worker' => 'RabbitApp\Command\LendingClubWorkerCommand'
        ]);
    }

    /**
     * @param $opts
     */
    public function options($opts)
    {
        $opts->add('v|verbose', 'verbose message');
        $opts->add('path:', 'required option with a value.');
        $opts->add('path?', 'optional option with a value');
        $opts->add('path+', 'multiple value option.');
    }
}