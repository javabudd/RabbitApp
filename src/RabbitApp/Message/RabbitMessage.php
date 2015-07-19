<?php

namespace RabbitApp\Message;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * This class exists because parent AMQPMessage does not contain a setter for the body variable
 *
 * Class RabbitMessage
 * @package RabbitApp\Message
 */
class RabbitMessage extends AMQPMessage
{
    /**
     * @param $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
}