<?php

declare(strict_types=1);

/**
 * @author Pavel Janda <me@paveljanda.com>
 * @copyright Copyright (c) 2020, Pavel Janda
 */

namespace Doctor\Rest\Controller\Exception;

use Doctor\Rest\Response\Response;

final class InvalidResponseException extends \Exception
{

	public function __construct(string $controllerClass, string $method)
	{
		parent::__construct(
			sprintf(
				'Method %s::%s() has to return a %s instance',
				$controllerClass,
				$method,
				Response::class
			)
		);
	}
}
