<?php

namespace Domain\User\Entities;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Hash;
use Support\User\Models\User;

class UserEntity
{
	/**
	 * @param string $name
	 * @param string $userName
	 * @param string $email
	 * @param string $password
	 * @return User
	 * @throws Exception
	 */
	public function factory(string $name, string $userName, string $email, string $password): User
	{
		$user = new User();
		$user->name = $name;
		$user->user_name = $userName;
		$user->email = $email;
		$user->password = $this->createHash($password);
		$user->validation_code = $this->createValidationCode();
		$user->validation_code_validation_date = $this->createValidationCodeValidationDate(10);
		return $user;
	}

	/**
	 * @return int
	 * @throws Exception
	 */
	public function createValidationCode(): int
	{
		try {
			return random_int(10000000, 99999999);
		} catch (Exception $e) {
			throw new Exception($e);
		}
	}

	public function createValidationCodeValidationDate($minutes): Carbon
	{
		return Carbon::now()->addMinutes($minutes);
	}

	/**
	 * @param string $value
	 * @return string
	 */
	public function createHash(string $value): string
	{
		return Hash::make($value);
	}

}
