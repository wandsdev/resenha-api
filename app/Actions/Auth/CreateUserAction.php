<?php

namespace App\Actions\Auth;

use App\DTO\UserDTO;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\User\UserAuthService;
use Exception;
use Illuminate\Database\Eloquent\Model;

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
		$validationCodeTime = config('auth.validation_code_time');
		$userDTO->validation_code = $this->userAuthService->createValidationCode();
		$userDTO->validation_code_validation_date = $this->userAuthService->createValidationCodeValidationDate($validationCodeTime);
		$userDTO->password = $this->userAuthService->createPasswordHash($userDTO->password);
		return $this->userRepository->createUser($userDTO->toArray());
	}
}
