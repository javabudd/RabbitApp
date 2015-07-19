<?php

namespace RabbitApp;

use CLIFramework\Application;

class RabbitCli extends Application
{
    public function init()
    {
        $this->command('list', '\RabbitApp\Command\ListCommand');

        // Commands/Publishers
        $this->command('benchmark', '\RabbitApp\Command\BenchmarkCommand');
        $this->command('render-pdf', 'RabbitApp\Command\RenderPdfCommand');

        // Workers
        $this->command('benchmark-worker', 'RabbitApp\Command\BenchmarkWorkerCommand');
        $this->command('render-pdf-worker', 'RabbitApp\Command\RenderPdfWorkerCommand');
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