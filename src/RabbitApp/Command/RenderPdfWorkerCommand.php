<?php

namespace RabbitApp\Command;

use CLIFramework\Command;
use RabbitApp\RabbitDi;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use RabbitApp\Worker\RenderPdfWorker;

class RenderPdfWorkerCommand extends Command
{
    public function execute()
    {
        try {
            /** @var RenderPdfWorker $render_pdf_worker */
            $render_pdf_worker = RabbitDi::get(RenderPdfWorker::class);
            $this->logger->info('Render PDF worker thread started. Stop the worker with CTRL+C');
            $render_pdf_worker->run();
        } catch (AMQPRuntimeException $e) {
            $this->logger->error('Unable to start the worker.');
        }
    }
}