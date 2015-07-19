<?php

namespace RabbitApp;

use CLIFramework\Application;

class RabbitCli extends Application
{
    public function init()
    {
        $this->command( 'list', '\RabbitApp\Command\ListCommand' );
        $this->command( 'benchmark', '\RabbitApp\Command\BenchmarkCommand' );
        $this->command(' benchmark-worker', 'RabbitApp\Command\BenchmarkWorkerCommand');
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