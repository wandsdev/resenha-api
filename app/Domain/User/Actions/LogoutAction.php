<?php


namespace Domain\User\Actions;


use Domain\User\Services\UserAuthService;

class LogoutAction
{
	public function __construct(public UserAuthService $userAuthService)
	{}

	public function execute()
	{
		$this->userAuthService->logout();
	}
}
