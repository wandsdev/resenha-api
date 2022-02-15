<?php

namespace Modules\User\Http\Controllers;

use App\Exceptions\ApiException;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\User\Helpers\Messages;
use Modules\User\Http\Requests\Auth\AccountValidationRequest;
use Modules\User\Http\Requests\Auth\LoginRequest;
use Modules\User\Http\Requests\Auth\RegisterUserRequest;
use Modules\User\Services\Auth\LoginService;
use Modules\User\Services\Auth\RegisterService;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(
//    	public AuthService $authService,
		public RegisterService $registerService,
		public LoginService $loginService,
	) {}

	/**
	 * @param LoginRequest $request
	 * @throws ApiException
	 */
	public function login(LoginRequest $request)
	{
		$credentials = $request->only('email', 'password');
		$this->loginService->login($credentials);
	}

	/**
	 * @param RegisterUserRequest $request
	 * @return JsonResponse
	 */
	public function register(RegisterUserRequest $request): JsonResponse
	{
		try {
			$user = $this->registerService->register($request->all());
			return $this->responseSuccess(
				['name' => $user->name, 'email' => $user->email],
				Messages::CREATED_USER,
				201
			);
		} catch (\Exception $e) {
			return $this->responseExceptionError($e, 500);
		}
	}

	public function accountValidation(AccountValidationRequest $request)
	{

	}

}
