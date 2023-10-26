<?php declare(strict_types = 1);

namespace Doctor\Rest\Response;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;

final class TextResponse extends Response
{

	public function __construct(mixed $data, int $statusCode = 200)
	{
		parent::__construct(
			$statusCode,
			['Content-Type' => 'text/plain'],
			Utils::streamFor(json_encode($data))
		);
	}

}
