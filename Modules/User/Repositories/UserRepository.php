<?php


namespace App\Repositories;


use Modules\User\Entities\User;
use App\Repositories\Repository;

class UserRepository extends Repository
{
    /** @var User $model*/
    protected $model;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}
