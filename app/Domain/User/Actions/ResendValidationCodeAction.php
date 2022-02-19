<?php


namespace Domain\User\Actions;


use Application\Core\Exceptions\ApiException;
use Domain\Shared\Services\MessageService;
use Domain\User\DTO\UserDTO;
use Domain\User\Services\UserService;
use Support\User\Repositories\UserRepository;

class ResendValidationCodeAction
{
	public function __construct(
		public UserRepository $userRepository,
		public UserService $userService,
	) {}

	public function execute(UserDTO $userDTO)
	{
		$user = $this->userRepository->findByEmailOrFail($userDTO->email);

		if ($user->email_verified) {
			throw new ApiException(MessageService::user('ACCOUNT_ALREADY_VALIDATED'), 422);
		}

		$user->validation_code = $this->userService->createValidationCode();
		$user->validation_code_validation_date = $this->userService->createValidationCodeValidationDate(10);
		$user->save();
		$this->userService->sendValidationCode($user);
	}
}
