<?php

namespace RabbitApp\Worker;

interface WorkerInterface
{
    public function run();

    public function consume();

    public function callback();
}