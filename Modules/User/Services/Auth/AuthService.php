<?php

namespace Modules\User\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Notification;
use Modules\User\Notifications\ValidationCodeUserAccount;

class AuthService
{
	/**
	 * @return int
	 * @throws Exception
	 */
	public function createValidationCode(): int
	{
		return random_int(10000000, 99999999);
	}

	public function createValidationCodeValidationDate($minutes): Carbon
	{
		return Carbon::now()->addMinutes($minutes);
	}

	public function sendValidationCode(User $user, bool $isResetPassword = false)
	{
		Notification::send($user, new ValidationCodeUserAccount($user, $isResetPassword));
	}
}
