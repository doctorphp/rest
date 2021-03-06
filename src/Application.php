<?php

declare(strict_types=1);

/**
 * @author Pavel Janda <me@paveljanda.com>
 * @copyright Copyright (c) 2020, Pavel Janda
 */

namespace Doctor\Rest;

use Doctor\Rest\Controller\ControllerProviderInterface;
use Doctor\Rest\Response\ResponseSender;
use Doctor\Rest\Response\ResponseStatus;
use Doctor\Rest\Response\TextResponse;
use Doctor\Rest\Route\Exception\MethodNotAllowedException;
use Doctor\Rest\Route\Exception\RouteNotFoundException;
use Doctor\Rest\Route\Router;
use Psr\Http\Message\RequestInterface;

class Application
{

	private bool $debugMode;
	private ControllerProviderInterface $controllerProvider;
	private Router $router;
	private RequestInterface $request;
	private ResponseSender $responseSender;


	public function __construct(
		bool $debugMode,
		ControllerProviderInterface $controllerProvider,
		Router $router,
		RequestInterface $request,
		ResponseSender $responseSender
	) {
		$this->debugMode = $debugMode;
		$this->controllerProvider = $controllerProvider;
		$this->router = $router;
		$this->request = $request;
		$this->responseSender = $responseSender;
	}


	public function run(): void
	{
		try {
			$match = $this->router->findMatch($this->request);
		} catch (\Throwable $e) {
			$this->handleError($e);

			return;
		}

		$controller = $this->controllerProvider->getByClass(
			$match->getRoute()->getControllerClass()
		);
		$response = $controller->run($match->getMethod(), $match->getParams());

		$this->responseSender->send($response);
	}


	protected function handleError(\Throwable $e): void
	{
		if ($this->debugMode) {
			throw $e;
		}

		if ($e instanceof RouteNotFoundException) {
			$this->responseSender->send(
				new TextResponse(
					'Not Found',
					ResponseStatus::STATUS_404_NOT_FOUND
				)
			);
		} elseif ($e instanceof MethodNotAllowedException) {
			$this->responseSender->send(
				new TextResponse(
					'Method Not Allowed',
					ResponseStatus::STATUS_405_METHOD_NOT_ALLOWED
				)
			);
		}

		$this->responseSender->send(
			new TextResponse(
				'Internal Server Error',
				ResponseStatus::STATUS_500_INTERNAL_SERVER_ERROR
			)
		);
	}
}
