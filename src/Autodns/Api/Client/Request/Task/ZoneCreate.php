<?php

namespace Autodns\Api\Client\Request\Task;

use Autodns\Api\Client\Request\Task;

class ZoneCreate implements Task
{
    private $zone;

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
            'code'  => '0201',
            'zone'  => $this->zone,
        ];
    }
}
