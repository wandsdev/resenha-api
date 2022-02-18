<?php

namespace Domain\User\Contracts\Repositories;

interface IUserRepository
{
	public function findUser();

	public function createUser(array $user);
}
