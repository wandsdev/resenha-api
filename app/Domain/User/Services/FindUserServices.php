<?php

namespace Domain\User\Services;

use Domain\User\Contracts\Repositories\IUserRepository;
use Support\User\Models\User;

class FindUserServices
{
	public function __construct(
		public IUserRepository $userRepository
	) {}

	public function execute()
	{
		/** @var User $user */
		$user = $this->userRepository->findUser();
		return $user;
	}
}
