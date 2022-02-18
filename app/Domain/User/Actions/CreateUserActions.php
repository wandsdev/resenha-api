<?php

namespace App\Domain\User\Actions;

use Domain\User\Entities\UserEntity;
use Exception;
use Support\User\Models\User;

class CreateUserActions
{
	public function __construct(
		private UserEntity $userEntity
	)
	{
	}

	/**
	 * @param array $requestData
	 * @throws Exception
	 */
	public function execute(array $requestData)
	{
//		$userEntity = new UserEntity($requestData['name'], $requestData['email'], $requestData['password']);
		$user = $this->userEntity->factory($requestData['name'], $requestData['user_name'], $requestData['email'], $requestData['password']);
		vdd($user->save());
//		unset($requestData['password_confirmation']);
//		$requestData['validation_code'] = $this->authService->createValidationCode();
//		$requestData['validation_code_validation_date'] = $this->authService->createValidationCodeValidationDate(10);
//		$requestData['password'] = Hash::make($requestData['password']);
//		$user = $this->userRepository->createUser($requestData);
//		$this->authService->sendValidationCode($user);
//		return $user;
	}
}
