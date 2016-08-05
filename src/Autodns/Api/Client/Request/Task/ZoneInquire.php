<?php

namespace Autodns\Api\Client\Request\Task;

use Autodns\Api\Client\Request\Task;

class ZoneInquire implements Task
{
    private $domain;

    /**
     * @param $domain
     * @return $this
     */
    public function domain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        $array = [
            'code'  => '0205',
            'zone'  => ['name' => $this->domain],
        ];

        return $array;
    }
}
