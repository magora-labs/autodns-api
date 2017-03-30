<?php

namespace Autodns\Api\Client;


class Response 
{
    /**
     * @var array
     */
    private $payload;

    /**
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        $statusType = $this->getStatusType();
        return ($statusType == 'success') || ($statusType == 'notify');
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->payload['result']['status']['code'];
    }

    /**
     * @return string
     */
    public function getStatusType()
    {
        return $this->payload['result']['status']['type'];
    }

    /**
     * @return string
     */
    public function getStatusReturnObject()
    {
        if ( isset($this->payload['result']['status']['object']) ) {
            return $this->payload['result']['status']['object'];
        }
        return false;
    }

    /**
     * @return string
     */
    public function getServerTransactionId()
    {
        if ( isset($this->payload['stid']) ) {
            return $this->payload['stid'];
        }

        return false;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }
}
