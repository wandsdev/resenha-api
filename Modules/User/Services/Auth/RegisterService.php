<?php


namespace Modules\User\Services\Auth;


use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\User\Repositories\UserRepository;

class RegisterService
{
	public function __construct(
		public AuthService $authService,
		public UserRepository $userRepository
	)
	{}

	/**
	 * @param array $requestData
	 * @return User|Model
	 * @throws Exception
	 */
	public function register(array $requestData): Model|User
	{
		unset($requestData['password_confirmation']);
		$requestData['validation_code'] = $this->authService->createValidationCode();
		$requestData['validation_code_validation_date'] = $this->authService->createValidationCodeValidationDate(10);
		$requestData['password'] = Hash::make($requestData['password']);
		$user = $this->userRepository->createUser($requestData);
		$this->authService->sendValidationCode($user);
		return $user;
	}
}
