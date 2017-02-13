<?php

namespace Autodns\Api\Client\Request\Task;

use Autodns\Api\Client\Request\Task;

class PollAck implements Task
{
    private $message;

    /**
     * @param message-id
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        $array = array(
            'code'      => '0906',
            'message'    => ['id' => $this->message],
        );

        return $array;
    }
}
