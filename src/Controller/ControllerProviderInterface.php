<?php declare(strict_types = 1);

namespace Doctor\Rest\Controller;

interface ControllerProviderInterface
{

	public function getByClass(string $class): Controller;

}
