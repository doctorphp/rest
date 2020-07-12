<?php

declare(strict_types=1);

/**
 * @author Pavel Janda <me@paveljanda.com>
 * @copyright Copyright (c) 2020, Pavel Janda
 */

namespace Doctor\Rest\Route\Exception;

final class InvalidMethodNameException extends \Exception
{

	public function __construct(string $controllerClass, string $expecting, string $actual)
	{
		parent::__construct(
			sprintf(
				'Invalid method name. Expecting: %s::%s(), got: ::%s()',
				$controllerClass,
				$expecting,
				$actual
			)
		);
	}
}
