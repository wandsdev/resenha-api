<?php

namespace Domain\User\Services;

use Application\User\Notifications\ValidationCodeUserAccount;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Support\User\Models\User;

class UserService
{
	/**
	 * @return int
	 * @throws Exception
	 */
	public function createValidationCode(): int
	{
		return random_int(10000000, 99999999);
	}

	/**
	 * @param $minutes
	 * @return Carbon
	 */
	public function createValidationCodeValidationDate($minutes): Carbon
	{
		return Carbon::now()->addMinutes($minutes);
	}

	/**
	 * @param string $password
	 * @return string
	 */
	public function createPasswordHash(string $password): string
	{
		return Hash::make($password);
	}

	/**
	 * @param User $user
	 * @param bool $isResetPassword
	 */
	public function sendValidationCode(User $user, bool $isResetPassword = false)
	{
		Notification::send($user, new ValidationCodeUserAccount($user, $isResetPassword));
	}

	/**
	 * @param User $user
	 * @return bool
	 */
	public function codeIsExpired(User $user): bool
	{
		$validationCodeValidationDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->validation_code_validation_date);
		$currentDate = Carbon::now();
		return $currentDate > $validationCodeValidationDate;
	}
}
