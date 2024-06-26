<?php declare(strict_types = 1);

namespace Doctor\Rest\Route;

final class RouterCache
{

	public const KEY_HTTP_METHOD = 0;
	public const KEY_PATH = 1;
	public const KEY_CONTROLLER_CLASS = 2;

	private string $cacheFile;

	private int $routeNumber = 0;

	/** @var array<string, mixed> */
	private static array $data = [];

	public function __construct(string $cacheDir)
	{
		$this->cacheFile = $cacheDir . '/router/CompiledRouter.php';

		if (file_exists($this->cacheFile)) {
			self::$data = require $this->cacheFile;
			$this->routeNumber = count(self::$data);
		}

		if (!file_exists(dirname($this->cacheFile))) {
			mkdir(dirname($this->cacheFile));
		}
	}

	public function add(string $httpMethod, string $path, string $controllerClass): string
	{
		$this->routeNumber++;
		$key = 'route' . $this->routeNumber;
		self::$data[$key] = [
			self::KEY_HTTP_METHOD => $httpMethod,
			self::KEY_PATH => $path,
			self::KEY_CONTROLLER_CLASS => $controllerClass,
		];

		return $key;
	}

	public function clear(): void
	{
		@unlink($this->cacheFile); // @ - File may not exist
		self::$data = [];
		$this->routeNumber = 0;
	}

	public function store(): void
	{
		file_put_contents(
			$this->cacheFile,
			'<?php return ' . var_export(self::$data, true) . ';'
		);
	}

	/**
	 * @param array<mixed> $arguments
	 * @return array<mixed>
	 */
	public static function __callStatic(string $name, array $arguments): array
	{
		if (!isset(self::$data[$name])) {
			throw new \InvalidArgumentException(
				sprintf('Cached route with index [%d] not found', $name)
			);
		}

		return self::$data[$name];
	}

}
