<?php

namespace Application\User\Controllers;

use Application\Core\Http\Controllers\Controller;
use Application\User\Requests\Auth\RegisterUserRequest;
use Application\User\Requests\Auth\ResendValidateCodeRequest;
use Application\Core\Response\ApiResponse;
use Application\User\Requests\Auth\AccountValidationRequest;
use Domain\Shared\Factories\DTOFactory;
use Domain\User\Actions\AccountValidateAction;
use Domain\User\Actions\CreateUserAction;
use Domain\User\Services\FindUserServices;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
	use ApiResponse;

	public function __construct(
		public FindUserServices $findUserServices,
		public DTOFactory $dtoFactory,
	) {}

	public function findUser(): JsonResponse
	{
		$user = $this->findUserServices->execute();
		return response()->json(['user' => $user], 200);
	}

	/**
	 * @param RegisterUserRequest $request
	 * @param CreateUserAction $createUserAction
	 * @return JsonResponse
	 */
	public function register(RegisterUserRequest $request, CreateUserAction $createUserAction): JsonResponse
	{
		try {
			$userDTO = $this->dtoFactory->createUserDTO($request->all());
			$user = $createUserAction->execute($userDTO);
			return $this->responseSuccess($user->toArray(), 201);
		} catch (Exception $e) {
			return $this->responseExceptionError($e);
		}
	}

	public function accountValidation(
		AccountValidationRequest $request,
		AccountValidateAction $accountValidateAction
	): JsonResponse
	{
		$userDTO = $this->dtoFactory->createUserDTO($request->all());
		$accountValidateAction->execute($userDTO);
		return $this->responseSuccess([], 204);
	}

	public function resendValidationCode(ResendValidateCodeRequest $request)
	{

	}
}
