<?php

namespace RabbitApp;

use CLIFramework\Application;

class RabbitCli extends Application
{
    public function init()
    {
        $this->command('list', '\RabbitApp\Command\ListCommand');

        // Commands/Publishers
        $this->commandGroup('Publishers', [
            'benchmark'  => '\RabbitApp\Command\BenchmarkCommand',
            'render-pdf' =>  'RabbitApp\Command\RenderPdfCommand'
        ]);

        // Workers
        $this->commandGroup('Workers', [
            'benchmark-worker'  => 'RabbitApp\Command\BenchmarkWorkerCommand',
            'render-pdf-worker' => 'RabbitApp\Command\RenderPdfWorkerCommand'
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