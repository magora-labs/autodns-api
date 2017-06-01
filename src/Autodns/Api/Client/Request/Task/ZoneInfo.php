<?php

namespace Autodns\Api\Client\Request\Task;

use Autodns\Api\Client\Request\Task;

class ZoneInfo implements Task
{
    private $name;
    private $system_ns;

    /**
     * @param $zone
     * @return $this
     */
    public function zone($name, $system_ns)
    {
        $this->name = $name;
        $this->system_ns = $system_ns;
        return $this;
    }

    public function asArray()
    {
        return [
            'code'  => '0205',
            'zone' => [
                'name' => $this->name,
                'system_ns' => $this->system_ns
            ]
        ];
    }
}