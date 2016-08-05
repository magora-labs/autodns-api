<?php

namespace Autodns\Api\Client\Request\Task;

use Autodns\Api\Client\Request\Task;

class ZoneDelete implements Task
{
    private $zone;

    /**
     * @param $domain
     * @return $this
     */
    public function domain($domain)
    {
        $this->zone = ['name' => $domain];
        return $this;
    }

    /**
     * @param $zone
     * @return $this
     */
    public function zone($zone)
    {
        $this->zone = $zone;
        return $this;
    }

    public function asArray()
    {
        return [
            'code'  => '0203',
            'zone'  => $this->zone,
        ];
    }
}
