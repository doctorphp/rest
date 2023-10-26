<?php declare(strict_types = 1);

namespace Doctor\Rest\Response;

use Psr\Http\Message\ResponseInterface;

final class ResponseWriter
{

	private const CHUNK_SIZE = 4096;

	public function write(ResponseInterface $response): void
	{
		$this->writeStatus($response);
		$this->writeHeaders($response);
		$this->writeBody($response);
	}

	public function writeHeaders(ResponseInterface $response): void
	{
		foreach ($response->getHeaders() as $name => $values) {
			foreach ($values as $value) {
				$header = sprintf('%s: %s', $name, $value);
				header($header, false);
			}
		}
	}

	private function writeStatus(ResponseInterface $response): void
	{
		$statusLine = sprintf(
			'HTTP/%s %s %s',
			$response->getProtocolVersion(),
			$response->getStatusCode(),
			$response->getReasonPhrase()
		);

		header($statusLine, true, $response->getStatusCode());
	}

	/**
	 * @see https://github.com/slimphp/Slim/blob/4.x/Slim/ResponseEmitter.php
	 */
	private function writeBody(ResponseInterface $response): void
	{
		$body = $response->getBody();

		if ($body->isSeekable()) {
			$body->rewind();
		}

		$amountToRead = (int) $response->getHeaderLine('Content-Length');

		if ($amountToRead === 0) {
			$amountToRead = $body->getSize();
		}

		if ($amountToRead !== 0) {
			while ($amountToRead > 0 && !$body->eof()) {
				$length = min(self::CHUNK_SIZE, $amountToRead);
				$data = $body->read($length);
				echo $data;

				$amountToRead -= strlen($data);

				if (connection_status() !== CONNECTION_NORMAL) {
					break;
				}
			}
		} else {
			while (!$body->eof()) {
				echo $body->read(self::CHUNK_SIZE);

				if (connection_status() !== CONNECTION_NORMAL) {
					break;
				}
			}
		}
	}

}
