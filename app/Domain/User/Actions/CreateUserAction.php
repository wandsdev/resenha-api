<?php

namespace Domain\User\Actions;

use Domain\User\Services\UserAuthService;
use Domain\User\DTO\UserDTO;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Support\User\Models\User;
use Support\User\Repositories\UserRepository;

class CreateUserAction
{
	public function __construct(
		private UserAuthService $userAuthService,
		private UserRepository $userRepository
	) {}

	/**
	 * @param UserDTO $userDTO
	 * @return Model|User
	 * @throws Exception
	 */
	public function execute(UserDTO $userDTO): Model|User
	{
		$validationCodeTime = config('domains.user.validation_code_time');
		$userDTO->validation_code = $this->userAuthService->createValidationCode();
		$userDTO->validation_code_validation_date = $this->userAuthService->createValidationCodeValidationDate($validationCodeTime);
		$userDTO->password = $this->userAuthService->createPasswordHash($userDTO->password);
		return $this->userRepository->createUser($userDTO->toArray());
	}
}
