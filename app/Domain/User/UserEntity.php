<?php

namespace App\Domain\User;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserEntity
{
	/**
	 * @var string
	 */
	private string $name;

	/**
	 * @var string
	 */
	private string $email;

	/**
	 * @var string
	 */
	private string $password;

	/**
	 * @var string|null
	 */
	private string|null $passwordConfirmation;

	/**
	 * @var string
	 */
	private string $validationCode;

	/**
	 * @var DateTime
	 */
	private DateTime $validationCodeValidationDate;

	/**
	 * @var bool
	 */
	private bool $emailVerified = false;

	/**
	 * UserEntity constructor.
	 * @param string $name
	 * @param string $userName
	 * @param string $email
	 * @param string $password
	 * @throws Exception
	 */
	public function __construct(string $name, string $userName, string $email, string $password)
	{
		$this->name = $name;
		$this->email = $email;
		$this->password = $this->createHash($password);
		$this->validationCode = $this->createValidationCode();
		$this->validationCodeValidationDate = $this->createValidationCodeValidationDate(10);
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getPasswordConfirmation(): string
	{
		return $this->passwordConfirmation;
	}

	/**
	 * @param string $passwordConfirmation
	 */
	public function setPasswordConfirmation(string $passwordConfirmation): void
	{
		$this->passwordConfirmation = $passwordConfirmation;
	}

	/**
	 * @return string
	 */
	public function getValidationCode(): string
	{
		return $this->validationCode;
	}

	/**
	 * @param string $validationCode
	 */
	public function setValidationCode(string $validationCode): void
	{
		$this->validationCode = $validationCode;
	}

	/**
	 * @return DateTime
	 */
	public function getValidationCodeValidationDate(): DateTime
	{
		return $this->validationCodeValidationDate;
	}

	/**
	 * @param DateTime $validationCodeValidationDate
	 */
	public function setValidationCodeValidationDate(DateTime $validationCodeValidationDate): void
	{
		$this->validationCodeValidationDate = $validationCodeValidationDate;
	}

	/**
	 * @return bool
	 */
	public function isEmailVerified(): bool
	{
		return $this->emailVerified;
	}

	/**
	 * @param bool $emailVerified
	 */
	public function setEmailVerified(bool $emailVerified): void
	{
		$this->emailVerified = $emailVerified;
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
