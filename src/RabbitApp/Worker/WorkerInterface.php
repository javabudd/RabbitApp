<?php

namespace RabbitApp\Worker;

interface WorkerInterface
{
    public function run();

    public function consume($channel);

    public function callback();

    public function getChannel();
}