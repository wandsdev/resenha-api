<?php


namespace Domain\User\Actions;


use Domain\Shared\Services\MessageService;
use Domain\User\Services\UserAuthService;
use Application\Core\Exceptions\ApiException;
use Domain\User\DTO\UserDTO;
use Support\User\Repositories\UserRepository;

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

		if ($this->userAuthService->codeIsExpired($user)) {
			throw new ApiException(MessageService::user('VALIDATION_CODE_EXPIRATION'), 422);
		}

		if ($userDTO->validation_code !== $user->validation_code) {
			throw new ApiException(MessageService::user('VALIDATION_CODE_INVALID'), 422);
		}

		$this->userRepository->accountValidate($user);
	}
}
