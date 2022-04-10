<?php

namespace App\Actions\Auth;

use App\Exceptions\ApiException;
use App\Services\Messages\MessageService;
use App\DTO\UserDTO;
use App\Services\User\UserAuthService;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;

class ResetPasswordAction
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

		if ($userDTO->validation_code !== $user->validation_code) {
			throw new ApiException(MessageService::user('VALIDATION_CODE_INVALID'), 422);
		}

		if ($this->userAuthService->codeIsExpired($user)) {
			throw new ApiException(MessageService::user('VALIDATION_CODE_EXPIRATION'), 422);
		}

		if (Hash::check($userDTO->password, $user->password)) {
			throw new ApiException(MessageService::user('SAME_LAST_PASSWORD'), 422);
		}

		$user->password = Hash::make($userDTO->password);
		$this->userRepository->save($user);
	}
}
