<?php

namespace App\Services\User;

use App\Models\User;
use App\Notifications\ValidationCodeUserAccount;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use function config;

class UserAuthService
{

	public function __construct(public UserRepository $userRepository)
	{}

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

	public function generateAndSendValidationCode(User $user, bool $isResetPassword = false)
	{
		$validationCodeTime = config('auth.validation_code_time');
		$user->validation_code = $this->createValidationCode();
		$user->validation_code_validation_date = $this->createValidationCodeValidationDate($validationCodeTime);
		$this->userRepository->save($user);
		$this->sendValidationCode($user, $isResetPassword);
	}

	/**
	 * @param User $user
	 * @return array
	 */
	public function getUserData(User $user): array
	{
		return [
			'token' => $user->createToken('api-token')->plainTextToken,
			'token_type' => 'Bearer',
			'user' => [
				'name' => $user->name,
				'user_name' => $user->user_name,
				'email' => $user->email,
			]
		];
	}

	public function logout()
	{
		Auth::user()->tokens()->delete();
	}
}
