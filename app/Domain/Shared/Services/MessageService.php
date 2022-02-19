<?php

namespace Domain\Shared\Services;

use Domain\Shared\Messages\Messages;

class MessageService
{
	/**
	 * @param string $name
	 * @return string
	 */
	public static function user(string $name): string
	{
		return self::getMessage($name, Messages::USER);
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public static function group(string $name): string
	{
		return self::getMessage($name, Messages::GROUP);
	}

	private static function getMessage(string $name, array $arrayMessages)
	{
		$key = array_search($name, $arrayMessages);

		if ($key === false) {
			return Messages::MESSAGE_NOT_FOUND;
		}

		return $arrayMessages[$key];
	}
}
