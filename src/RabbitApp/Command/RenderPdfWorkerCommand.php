<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use RabbitApp\Worker\RenderPdfWorker;

/**
 * Class RenderPdfWorkerCommand
 * @package RabbitApp\Command
 */
class RenderPdfWorkerCommand extends Command
{
    public function execute()
    {
        /** @var RenderPdfWorker $render_pdf_worker */
        $render_pdf_worker = RabbitDi::get(RenderPdfWorker::class);
        $render_pdf_worker->setQueueName('render_pdf_queue');
        $this->logger->info('Render PDF worker thread started. Stop the worker with CTRL+C');
        $render_pdf_worker->run();
    }
}