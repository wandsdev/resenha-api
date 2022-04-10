<?php

namespace App\Actions\Auth;

use App\Exceptions\ApiException;
use App\Services\Messages\MessageService;
use App\DTO\UserDTO;
use App\Services\User\UserAuthService;
use App\Repositories\UserRepository;

class ResendValidationCodeAction
{
	public function __construct(
		public UserRepository $userRepository,
		public UserAuthService $userAuthService,
	) {}

	/**
	 * @param UserDTO $userDTO
	 * @return void
	 * @throws ApiException
	 */
	public function execute(UserDTO $userDTO)
	{
		$user = $this->userRepository->findByEmailOrFail($userDTO->email);

		if ($user->email_verified) {
			throw new ApiException(MessageService::user('ACCOUNT_ALREADY_VALIDATED'), 401);
		}

		$this->userAuthService->generateAndSendValidationCode($user);
	}
}
