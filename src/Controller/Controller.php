<?php

declare(strict_types=1);

/**
 * @author Pavel Janda <me@paveljanda.com>
 * @copyright Copyright (c) 2020, Pavel Janda
 */

namespace Doctor\Rest\Controller;

use Doctor\Rest\Controller\Exception\InvalidResponseException;
use Doctor\Rest\Controller\Exception\UndefinedMethodCallException;
use Doctor\Rest\Response\Response;

abstract class Controller
{

	/**
	 * @throws UndefinedMethodCallException
	 * @throws InvalidResponseException
	 * @param  array<mixed> $params
	 */
	public function run(string $method, array $params): Response
	{
		$method = strtolower($method);

		if (!method_exists($this, $method)) {
			throw new UndefinedMethodCallException(static::class, $method);
		}

		$response = call_user_func_array([$this, $method], $params); // @phpstan-ignore-line

		if (!$response instanceof Response) {
			throw new InvalidResponseException(static::class, $method);
		}

		return $response;
	}
}
