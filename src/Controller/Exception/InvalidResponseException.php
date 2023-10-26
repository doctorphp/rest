<?php declare(strict_types = 1);

namespace Doctor\Rest\Controller\Exception;

use Psr\Http\Message\ResponseInterface;

final class InvalidResponseException extends \Exception
{

	public function __construct(string $controllerClass, string $method)
	{
		parent::__construct(
			sprintf(
				'Method %s::%s() has to return a %s instance',
				$controllerClass,
				$method,
				ResponseInterface::class
			)
		);
	}

}
