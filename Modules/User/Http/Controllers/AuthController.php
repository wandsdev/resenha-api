<?php

namespace Modules\User\Http\Controllers;

use App\Exceptions\ApiException;
use App\Traits\TResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\Auth\LoginRequest;
use Modules\User\Services\Auth\AuthService;
use Modules\User\Services\Auth\LoginService;
use Modules\User\Services\UserService;

class AuthController extends Controller
{
    use TResponse;

    public function __construct(
    	public AuthService $authService,
		public LoginService $loginService,
		public UserService $userService
	) {}

	/**
	 * @param LoginRequest $request
	 * @throws ApiException
	 */
	public function login(LoginRequest $request)
	{
		var_dump('dddd');die;
		$credentials = $request->only('email', 'password');
		$this->loginService->login($credentials);
	}

}
