<?php

namespace Autodns\Api\Client\Request\Task;

use Autodns\Api\Client\Request\Task;

class PollInfo implements Task
{
    /**
     * @return array
     */
    public function asArray()
    {
        $array = [
            'code' => '0905',
        ];

        return $array;
    }
}
