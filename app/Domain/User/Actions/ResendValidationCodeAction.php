<?php


namespace Domain\User\Actions;


use Application\Core\Exceptions\ApiException;
use Domain\Shared\Services\MessageService;
use Domain\User\DTO\UserDTO;
use Domain\User\Services\UserAuthService;
use Support\User\Repositories\UserRepository;

class ResendValidationCodeAction
{
	public function __construct(
		public UserRepository $userRepository,
		public UserAuthService $userAuthService,
	) {}

	public function execute(UserDTO $userDTO)
	{
		$user = $this->userRepository->findByEmailOrFail($userDTO->email);

		if ($user->email_verified) {
			throw new ApiException(MessageService::user('ACCOUNT_NOT_VALIDATED'), 401);
		}

		$this->userAuthService->generateAndSendValidationCode($user);
	}
}
