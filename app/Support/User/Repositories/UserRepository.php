<?php

namespace Support\User\Repositories;

use Domain\Shared\Services\MessageService;
use Application\Core\Exceptions\ApiException;
use Domain\User\Contracts\Repositories\IUserRepository;
use Domain\User\Status\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Support\Shared\Abstracts\RepositoryBase;
use Support\User\Models\User;
use Support\User\Models\UserConnection;

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

	public static function test()
	{
		$query = "SELECT u.id, u.name, uc.status
 	  			FROM users u
	    		JOIN user_connections uc on uc.user_id_a = :id and uc.user_id_b = u.id
			UNION
			SELECT u.id, u.name, ucs.status
 	  			FROM users u
				JOIN user_connections ucs on ucs.user_id_b = :id2 and ucs.user_id_a = u.id
			   ";
		$params = ['id' => 2];
		$users = DB::select($query, $params);

		foreach ($users as $user) {
			$user->status_label = Status::getLabel($user->status);
		}
		return $users;
	}

	public static function test2($userId)
	{
		return DB::table('users as u')
			->join('user_connections as uc', function ($join) use ($userId) {
				$join->on('uc.user_id_b', '=', 'u.id')
					->where('uc.user_id_a', $userId);
			})->select(['u.id', 'u.name'])->simplePaginate();
	}

	public static function test3($userId)
	{
		return
			UserConnection::join('users as u', function ($join) use ($userId) {
				$join->on('user_connections.user_id_b', '=', 'u.id')
					->where('user_connections.user_id_a', $userId);
			})
				->select(['u.id', 'u.name', 'user_connections.status'])->simplePaginate();
		return DB::table('user_connections')->get();
		return DB::table('user_connections as uc')
			->join('users as u', function ($join) use ($userId) {
				$join->on('uc.user_id_b', '=', 'u.id')
					->where('uc.user_id_a', $userId);
			})->get('uc.status_label');
	}

	public static function test5()
	{
		return DB::table('users as u')
			->selectRaw('name')->get();
	}
}
