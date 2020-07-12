<?php

declare(strict_types=1);

/**
 * @author Pavel Janda <me@paveljanda.com>
 * @copyright Copyright (c) 2020, Pavel Janda
 */

namespace Doctor\Rest\Controller\Exception;

final class UndefinedMethodCallException extends \Exception
{

	public function __construct(string $controllerClass, string $method)
	{
		parent::__construct(
			sprintf('Undefined method call: %s::%s()', $controllerClass, $method)
		);
	}
}
