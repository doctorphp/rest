<?php

declare(strict_types=1);

/**
 * @author Pavel Janda <me@paveljanda.com>
 * @copyright Copyright (c) 2020, Pavel Janda
 */

namespace Doctor\Rest\Route;

final class Matched
{

	private Route $route;
	private string $method;
	/** @var array<mixed> */
	private array $params;


	/**
	 * @param array<mixed> $params
	 */
	public function __construct(Route $route, string $method, array $params)
	{
		$this->route = $route;
		$this->method = $method;
		$this->params = $params;
	}


	public function getRoute(): Route
	{
		return $this->route;
	}


	public function getMethod(): string
	{
		return $this->method;
	}


	/**
	 * @return array<mixed>
	 */
	public function getParams(): array
	{
		return $this->params;
	}
}
