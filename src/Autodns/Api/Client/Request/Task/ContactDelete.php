<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

class ContactDelete implements Task
{
	private $contactData = array();

	/**
	 * @param array $contactData
	 * @return $this
	 */
	public function fill(array $contactData)
	{
		$this->contactData = $contactData;
		return $this;
	}

	function __call( $name, $arguments ) {
		$fields = array(
			'id',
		);
		if ( in_array( $name, $fields ) ) {
			$this->contactData[ $name ] = $arguments[0];
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
			'code' => '0303',
			'handle' => $this->contactData
		);

		return $array;
	}
}

