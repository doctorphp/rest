<?php declare(strict_types = 1);

namespace Doctor\Rest\Route;

/**
 * @phpstan-implements \IteratorAggregate<string, Route>
 */
final class RouteCollection implements \Countable, \IteratorAggregate
{

	/** @var array<string, Route> */
	private array $routes = [];

	public function add(string $path, string $controllerName): self
	{
		$this->routes[$path] = new Route($path, $controllerName);

		return $this;
	}

	/**
	 * @return \ArrayIterator<string, Route>
	 */
	public function getIterator(): \ArrayIterator
	{
		return new \ArrayIterator($this->routes);
	}

	public function count(): int
	{
		return count($this->routes);
	}

}
