<?php

namespace Domain\User\Actions;

use Domain\User\Services\UserService;
use Domain\User\DTO\UserDTO;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Support\User\Models\User;
use Support\User\Repositories\UserRepository;

class CreateUserAction
{
	public function __construct(
		private UserService $userService,
		private UserRepository $userRepository
	) {}

	/**
	 * @param UserDTO $userDTO
	 * @return Model|User
	 * @throws Exception
	 */
	public function execute(UserDTO $userDTO): Model|User
	{
		$userDTO->validation_code = $this->userService->createValidationCode();
		$userDTO->validation_code_validation_date = $this->userService->createValidationCodeValidationDate(10);
		$userDTO->password = $this->userService->createPasswordHash($userDTO->password);
		return $this->userRepository->createUser($userDTO->toArray());
	}
}
