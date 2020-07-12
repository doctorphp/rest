<?php

declare(strict_types=1);

/**
 * @author Pavel Janda <me@paveljanda.com>
 * @copyright Copyright (c) 2020, Pavel Janda
 */

namespace Doctor\Rest\Controller;

interface ControllerProviderInterface
{

	public function getByClass(string $class): Controller;
}
