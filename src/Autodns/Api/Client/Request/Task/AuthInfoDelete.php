<?php

namespace Autodns\Api\Client\Request\Task;

use Autodns\Api\Client\Request\Task;

class AuthInfoDelete implements Task
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
            'code'      => '0113002',
            'domain'    => ['name' => $this->domain],
        );

        return $array;
    }
}
