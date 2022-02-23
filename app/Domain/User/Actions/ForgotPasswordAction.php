<?php

namespace Domain\User\Actions;

use Domain\User\DTO\UserDTO;
use Domain\User\Services\UserAuthService;
use Support\User\Repositories\UserRepository;

class ForgotPasswordAction
{
	public function __construct(
		private UserRepository $userRepository,
		private UserAuthService $userAuthService
	) {}

	public function execute(UserDTO $userDTO)
	{
		$user = $this->userRepository->findByEmailOrFail($userDTO->email);
		$this->userAuthService->generateAndSendValidationCode($user);
	}
}
