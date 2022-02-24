<?php


namespace Domain\User\Actions;


use Application\Core\Exceptions\ApiException;
use Domain\Shared\Services\MessageService;
use Domain\User\DTO\UserDTO;
use Domain\User\Services\UserAuthService;
use Illuminate\Support\Facades\Hash;
use Support\User\Repositories\UserRepository;

class ResetPasswordAction
{
	public function __construct(
		public UserRepository $userRepository,
		public UserAuthService $userAuthService,
	) {}

	public function execute(UserDTO $userDTO)
	{
		$user = $this->userRepository->findByEmailOrFail($userDTO->email);

		if ($this->userAuthService->codeIsExpired($user)) {
			throw new ApiException(MessageService::user('VALIDATION_CODE_EXPIRATION'), 422);
		}

		if ($userDTO->validation_code !== $user->validation_code) {
			throw new ApiException(MessageService::user('VALIDATION_CODE_INVALID'), 422);
		}

		if (Hash::check($userDTO->password, $user->password)) {
			throw new ApiException(MessageService::user('SAME_LAST_PASSWORD'), 422);
		}

		$user->password = Hash::make($userDTO->password);
		$this->userRepository->save($user);
	}
}
