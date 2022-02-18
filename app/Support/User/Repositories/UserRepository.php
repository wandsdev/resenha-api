<?php

namespace Support\User\Repositories;

use Domain\User\Contracts\Repositories\IUserRepository;
use Support\User\Models\User;

class UserRepository implements IUserRepository
{

	public function findUser()
	{
		return User::find(1);
	}

	public function createUser(array $user)
	{

	}
}
