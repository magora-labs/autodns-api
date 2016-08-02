<?php

namespace Autodns\Api\Client\Request\Task;

use Autodns\Api\Client\Request\Task;

class CancelationCreate implements Task
{
    private $cancelationData = [];

    /**
     * @param array $cancelationData
     * @return $this
     */
    public function fill(array $cancelationData)
    {
        $this->cancelationData = $cancelationData;
        return $this;
    }

    function __call($name, $arguments)
    {
        $fields = [
            'domain',
            'type',
            'execdate',
            'disconnect',
            'gaining_registrar',
        ];
        if (!in_array($name, $fields))
        {
            trigger_error('Call to undefined method '.__CLASS__.'::'.$name.'()', E_USER_ERROR);
        }

        $this->cancelationData[$name] = $arguments[0];
        return $this;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        $array = [
            'code'          => '0103101',
            'cancelation'   => $this->cancelationData,
        ];

        return $array;
    }
}
