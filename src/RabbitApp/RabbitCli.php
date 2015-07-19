<?php

namespace RabbitApp;

use CLIFramework\Application;

class RabbitCli extends Application
{
    public function init()
    {
        $this->command( 'list', '\RabbitApp\Command\ListCommand' );
        $this->command( 'ls', '\RabbitApp\Command\LSCommand' );
        $this->command(' ls-worker', 'RabbitApp\Command\LSWorkerCommand');
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