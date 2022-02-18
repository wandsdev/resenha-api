<?php

namespace App\Domain\User\Services;

use Domain\User\Contracts\Repositories\IUserRepository;

class FindUserServices
{
	public function __construct(
		public IUserRepository $userRepository
	) {}

	public function execute()
	{
		return $this->userRepository->findUser();
	}
}
