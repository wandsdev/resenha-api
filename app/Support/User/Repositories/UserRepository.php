<?php

namespace Support\User\Repositories;

use Domain\Shared\Services\MessageService;
use Application\Core\Exceptions\ApiException;
use Domain\User\Contracts\Repositories\IUserRepository;
use Illuminate\Database\Eloquent\Model;
use Support\Shared\Abstracts\RepositoryBase;
use Support\User\Models\User;

class UserRepository extends RepositoryBase implements IUserRepository
{
	public function __construct(
		private User $user,
	) {
		parent::__construct($user);
	}

	public function findUser(): User
	{
		return $this->user->find(1);
	}

	public function findByEmail($email)
	{
		return $this->model->where('email', $email);
	}

	/**
	 * @param $email
	 * @return mixed
	 * @throws ApiException
	 */
	public function findByEmailOrFail($email): mixed
	{
		$user = $this->findByEmail($email)->first();

		if (!$user) {
			throw new ApiException(MessageService::user('EMAIL_NOT_FOUND'), 401);
		}

		return $user;
	}

	/**
	 * @param array $user
	 * @return Model|User
	 */
	public function createUser(array $user): Model|User
	{
		return $this->user->create($user);
	}

	/**
	 * @param User $user
	 * @return User
	 */
	public function accountValidate(User $user): User
	{
		$user->email_verified = true;
		$user->save();
		return $user;
	}
}
