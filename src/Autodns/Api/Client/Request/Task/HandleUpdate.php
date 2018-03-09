<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

/**
 * Class HandleUpdate
 * @package Autodns\Api\Client\Request\Task
 */
class HandleUpdate implements Task
{
    private $handleData = array();
    private $replyTo;

    /**
     * @param array $handleData
     * @return $this
     */
    public function fill(array $handleData)
    {
        $this->handleData = $handleData;
        return $this;
    }

    public function replyTo($replyTo) {
        $this->replyTo = $replyTo;
        return $this;
    }

    function __call( $name, $arguments ) {
        $fields = array(
            'id',
            'alias',
            'type',

            'fname',
            'lname',
            'title',
            'organization',

            'address',
            'pcode',
            'city',
            'state',
            'country',

            'phone',
            'fax',
            'email',

            'sip',
            'protection',
            'nic_ref',
            'remarks',
            'extension'
        );
        if ( in_array( $name, $fields ) ) {
            $this->handleData[ $name ] = $arguments[0];
            return $this;
        }
        trigger_error('Call to undefined method '.__CLASS__.'::'.$name.'()', E_USER_ERROR);
    }

    /**
     * @return array
     */
    public function asArray()
    {
        $array = array(
            'code' => '0302',
            'handle' => $this->handleData
        );

        if ( $this->replyTo ) {
            $array['reply_to'] = $this->replyTo;
        }

        return $array;
    }
}
