<?php

declare(strict_types=1);

/**
 * @author Pavel Janda <me@paveljanda.com>
 * @copyright Copyright (c) 2020, Pavel Janda
 */

namespace Doctor\Rest\Response;

class JsonResponse extends Response
{

	/**
	 * @var mixed
	 */
	private $data;


	/**
	 * @param mixed $data
	 */
	public function __construct($data, int $status = ResponseStatus::STATUS_200_OK)
	{
		$this->data = $data;
		$this->status = $status;

		$this->setContentType('application/json');
	}


	public function getResponseData(): string
	{
		return json_encode($this->data, JSON_THROW_ON_ERROR);
	}
}
