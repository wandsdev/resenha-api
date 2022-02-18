<?php


namespace Application\Core\Exceptions;


use Throwable;

class ApiException extends \Exception
{
	/**
	 * ApiException constructor.
	 * @param string $message
	 * @param int $statusCode
	 * @param int $code
	 * @param Throwable|null $previous
	 */
	public function __construct(
		$message = "",
		public int $statusCode = 500,
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
}
