<?php

namespace Autodns\Api\Client\Request\Task;

use Autodns\Api\Client\Request\Task;

class AuthInfo1Create implements Task
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
        $array = array(
            'code'      => '0113001',
            'domain'    => ['name' => $this->domain],
        );

        return $array;
    }
}
