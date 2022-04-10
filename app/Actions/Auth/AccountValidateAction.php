<?php

namespace App\Actions\Auth;

use App\Services\Messages\MessageService;
use App\Services\User\UserAuthService;
use App\Exceptions\ApiException;
use App\DTO\UserDTO;
use App\Repositories\UserRepository;

class AccountValidateAction
{
	public function __construct(
		private UserRepository $userRepository,
		private UserAuthService $userAuthService
	) {}

	/**
	 * @param UserDTO $userDTO
	 * @throws ApiException
	 */
	public function execute(UserDTO $userDTO)
	{
		$user = $this->userRepository->findByEmailOrFail($userDTO->email);

		if ($userDTO->validation_code !== $user->validation_code) {
			throw new ApiException(MessageService::user('VALIDATION_CODE_INVALID'), 422);
		}

		if ($this->userAuthService->codeIsExpired($user)) {
			throw new ApiException(MessageService::user('VALIDATION_CODE_EXPIRATION'), 422);
		}

		$this->userRepository->accountValidate($user);
	}
}
