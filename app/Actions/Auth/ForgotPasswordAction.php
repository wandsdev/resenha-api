<?php

namespace App\Actions\Auth;

use App\DTO\UserDTO;
use App\Exceptions\ApiException;
use App\Services\User\UserAuthService;
use App\Repositories\UserRepository;

class ForgotPasswordAction
{
	public function __construct(
		private UserRepository $userRepository,
		private UserAuthService $userAuthService
	) {}

	/**
	 * @param UserDTO $userDTO
	 * @return void
	 * @throws ApiException
	 */
	public function execute(UserDTO $userDTO)
	{
		$user = $this->userRepository->findByEmailOrFail($userDTO->email);
		$this->userAuthService->generateAndSendValidationCode($user, true);
	}
}
