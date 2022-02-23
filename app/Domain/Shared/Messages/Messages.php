<?php

namespace Domain\Shared\Messages;

use Application\Core\Exceptions\ApiException;

class Messages
{
	public const MESSAGE_NOT_FOUND = 'MESSAGE_NOT_FOUND_IN_SERVER';

	public const USER = [
		'ACCOUNT_ALREADY_VALIDATED',
		'EMAIL_NOT_FOUND',
		'USER_NOT_FOUND',
		'VALIDATION_CODE_EXPIRATION',
		'VALIDATION_CODE_INVALID',
		'ACCOUNT_NOT_VALIDATED',
		'ACCOUNT_NOT_VALIDATED',
		'CREDENTIALS_INVALID',
		'LOGGED_OUT',
		'SAME_LAST_PASSWORD',
	];

	public const GROUP = [
		'GROUP_PERMISSION',
	];
}
