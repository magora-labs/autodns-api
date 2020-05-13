<?php
namespace Autodns\Api\Client\Request\Task;

use Autodns\Api\Client\Request\Task;

class DomainTransferNack implements Task
{
	private $domain;

	/**
	 * @param array $domainData
	 * @return $this
	 */
	public function domain(string $domain)
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
			'code' => '0106002',
			'transfer' => [
				'domain' => $this->domain,
				'type' => 'nack'
			]
		);

		return $array;
	}
}

