<?php declare(strict_types = 1);

namespace Doctor\Rest\Controller;

use Doctor\Rest\Controller\Exception\InvalidResponseException;
use Doctor\Rest\Controller\Exception\UndefinedMethodCallException;
use Psr\Http\Message\ResponseInterface;

abstract class Controller
{

	protected ?array $postData = null;

	/**
	 * @throws UndefinedMethodCallException
	 * @throws InvalidResponseException
	 * @param  array<mixed> $params
	 */
	public function run(string $method, array $params, ?array $postData): ResponseInterface
	{
		$this->postData = $postData;
		$method = strtolower($method);

		if (!method_exists($this, $method)) {
			throw new UndefinedMethodCallException(static::class, $method);
		}

		$response = call_user_func_array([$this, $method], $params); // @phpstan-ignore-line

		if (!$response instanceof ResponseInterface) {
			throw new InvalidResponseException(static::class, $method);
		}

		return $response;
	}

}
