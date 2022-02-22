<?php


namespace Domain\User\Actions;


use Application\Core\Exceptions\ApiException;
use Domain\Shared\Services\MessageService;
use Domain\User\DTO\UserDTO;
use Domain\User\Services\UserAuthService;
use Illuminate\Support\Facades\Auth;
use Support\User\Repositories\UserRepository;

class LoginAction
{
	public function __construct(
		public UserRepository $userRepository,
		public UserAuthService $userAuthService,
	) {}

	/**
	 * @param UserDTO $userDTO
	 * @return array
	 * @throws ApiException
	 */
	public function execute(UserDTO $userDTO): array
	{
		$credentials = $this->getCredentials($userDTO);

		if (!Auth::attempt($credentials)) {
			throw new ApiException(MessageService::user('CREDENTIALS_INVALID'), 401);
		}

		$user = $this->userRepository->findByEmailOrFail($userDTO->email);

		if (!$user->email_verified) {
			$this->userAuthService->generateAndSendValidationCode($user);
			throw new ApiException(MessageService::user('ACCOUNT_NOT_VALIDATED'), 401);
		}

		return $this->userAuthService->getUserData($user);
	}

	/**
	 * @param UserDTO $userDTO
	 * @return array
	 */
	private function getCredentials(UserDTO $userDTO): array
	{
		return array(
			'email' => $userDTO->email,
			'password' => $userDTO->password,
		);
	}
}
