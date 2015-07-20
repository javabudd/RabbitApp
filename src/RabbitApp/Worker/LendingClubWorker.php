<?php

namespace RabbitApp\Worker;

use Httpful\Request;

/**
 * Class LendingClubWorker
 * @package RabbitApp\Worker
 */
class LendingClubWorker extends AbstractWorker
{
    /**
     * Call LendingClub and gather all loans
     *
     * @return callable
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function callback()
    {
        $uri = 'https://api.lendingclub.com/api/investor/1/loans/listing';
        /** @var \PhpAmqpLib\Message\AMQPMessage $args */
        return function($args) use($uri) {
            $request  = Request::init('GET');
            $auth_key = json_decode($args->body)[0];
            $request->uri($uri);
            $request->addHeader('Accept', 'application/json');
            $request->addHeader('Content-Type', 'application/json');
            $request->addHeader('Authorization', $auth_key);
            /** @var \Httpful\Response $response */
            $response = $request->send();
            echo $response->code . PHP_EOL;
            // Perform DB operation with response
        };
    }
}