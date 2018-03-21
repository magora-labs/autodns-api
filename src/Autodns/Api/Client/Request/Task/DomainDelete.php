<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

class DomainDelete implements Task
{
	private $domainData = array();

	/**
	 * @param array $domainData
	 * @return $this
	 */
	public function fill(array $domainData)
	{
		$this->domainData = $domainData;
		return $this;
	}

	function __call( $name, $arguments ) {
		$fields = array(
			'name',
                        'transit',
                        'disconnect'
		);
		if ( in_array( $name, $fields ) ) {
			$this->domainData[ $name ] = $arguments[0];
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
			'code' => '0103',
			'domain' => $this->domainData
		);

		return $array;
	}
}

