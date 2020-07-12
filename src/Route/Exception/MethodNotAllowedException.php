<?php

declare(strict_types=1);

/**
 * @author Pavel Janda <me@paveljanda.com>
 * @copyright Copyright (c) 2020, Pavel Janda
 */

namespace Doctor\Rest\Route\Exception;

final class MethodNotAllowedException extends \Exception
{

	public function __construct(string $path, string $method, array $allowedMethods)
	{
		parent::__construct(
			sprintf(
				'Route %s - %s not found, allowed methods: %s',
				$method,
				$path,
				$allowedMethods === [] ? '' : implode(', ', $allowedMethods)
			)
		);
	}
}
