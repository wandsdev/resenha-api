<?php

namespace Application\User\Controllers;

use App\Domain\User\Actions\CreateUserActions;
use App\Domain\User\Services\FindUserServices;
use Application\Core\Http\Controllers\Controller;
use Application\User\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function __construct(
		public FindUserServices $findUserServices
	) {}

	public function findUser()
	{
		$user = $this->findUserServices->execute();
		return response()->json(['user' => $user], 200);
	}

	public function register(RegisterUserRequest $request, CreateUserActions $createUserActions)
	{
		$createUserActions->execute($request->all());
	}
}
