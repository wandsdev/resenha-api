<?php

namespace Modules\User\Services\Auth;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Auth;

class LoginService
{
	/**
	 * @param array $credentials
	 * @throws ApiException
	 */
	public function login(array $credentials)
	{
		if (auth()->attempt($credentials)) {
			throw new ApiException('Invalid credentials', 401);
		}
	}
}
