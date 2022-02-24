<?php

namespace Application\Core\Exceptions;

use Application\Core\Response\ApiResponse;
use Throwable;
use Exception;

class ApiException extends Exception
{
	use ApiResponse;

	/**
	 * ApiException constructor.
	 * @param string $message
	 * @param int $statusCode
	 * @param array $errors
	 * @param int $code
	 * @param Throwable|null $previous
	 */
	public function __construct(
		$message = "",
		public int $statusCode = 500,
		public array $errors = [],
		$code = 0,
		Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

	/**
	 * @return int
	 */
	public function getStatusCode(): int
	{
		return $this->statusCode;
	}

	/**
	 * @return array
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}
}
