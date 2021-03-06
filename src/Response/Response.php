<?php

declare(strict_types=1);

/**
 * @author Pavel Janda <me@paveljanda.com>
 * @copyright Copyright (c) 2020, Pavel Janda
 */

namespace Doctor\Rest\Response;

abstract class Response
{

	protected int $status = 200;
	protected ?string $contentType = null;


	abstract public function getResponseData(): string;


	public function setStatus(int $status): void
	{
		$this->status = $status;
	}


	public function getStatus(): int
	{
		return $this->status;
	}


	public function setContentType(?string $contentType): void
	{
		$this->contentType = $contentType;
	}


	public function getContentType(): ?string
	{
		return $this->contentType;
	}
}
