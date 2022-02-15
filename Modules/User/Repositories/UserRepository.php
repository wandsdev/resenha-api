<?php


namespace Modules\User\Repositories;


use App\Models\User;
use App\Repositories\Repository;
use JetBrains\PhpStorm\Pure;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository
{
	/**
	 * UserRepository constructor.
	 * @param User $user
	 */
    #[Pure] public function __construct(
    	public User $user
	)
    {
        parent::__construct($user);
    }

	/**
	 * Selects
	 * @param $email
	 * @return Model|User|null
	 */
    public function findByEmail($email): Model|User|null
	{
        return $this->model->where('email', $email)->first();
    }

	/**
	 * Create
	 * @param array $userData
	 * @return User|Model
	 */
	public function createUser(array $userData): Model|User
	{
		return $this->user->create($userData);
	}
}
