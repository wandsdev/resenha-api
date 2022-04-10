<?php

namespace App\Actions\Auth;

use App\Services\User\UserAuthService;

class LogoutAction
{
	public function __construct(public UserAuthService $userAuthService)
	{}

	public function execute()
	{
		$this->userAuthService->logout();
	}
}
