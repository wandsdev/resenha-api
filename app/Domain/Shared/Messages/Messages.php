<?php

namespace Domain\Shared\Messages;

use Application\Core\Exceptions\ApiException;

class Messages
{
	public const MESSAGE_NOT_FOUND = 'MESSAGE_NOT_FOUND_IN_SERVER';

	public const USER = [
		'EMAIL_NOT_FOUND',
		'USER_NOT_FOUND',
		'VALIDATION_CODE_EXPIRATION',
		'VALIDATION_CODE_INVALID',
	];

	public const GROUP = [
		'GROUP_PERMISSION',
	];
}
