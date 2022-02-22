<?php

namespace Application\User\Controllers;

use Application\Core\Exceptions\ApiException;
use Application\Core\Http\Controllers\Controller;
use Application\User\Requests\Auth\LoginRequest;
use Application\User\Requests\Auth\RegisterUserRequest;
use Application\User\Requests\Auth\ResendValidateCodeRequest;
use Application\Core\Response\ApiResponse;
use Application\User\Requests\Auth\AccountValidationRequest;
use Domain\Shared\Factories\DTOFactory;
use Domain\Shared\Services\MessageService;
use Domain\User\Actions\AccountValidateAction;
use Domain\User\Actions\CreateUserAction;
use Domain\User\Actions\LoginAction;
use Domain\User\Actions\LogoutAction;
use Domain\User\Actions\ResendValidationCodeAction;
use Domain\User\Services\FindUserServices;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

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
	 * @throws UnknownProperties
	 */
	public function register(RegisterUserRequest $request, CreateUserAction $createUserAction): JsonResponse
	{
		$userDTO = $this->dtoFactory->createUserDTO($request->all());
		$user = $createUserAction->execute($userDTO);
		return $this->responseSuccess($user->toArray(), 201);
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

	/**
	 * @param ResendValidateCodeRequest $request
	 * @param ResendValidationCodeAction $resendValidationCodeAction
	 * @return JsonResponse
	 * @throws UnknownProperties
	 * @throws ApiException
	 */
	public function resendValidationCode(
		ResendValidateCodeRequest $request,
		ResendValidationCodeAction $resendValidationCodeAction
	): JsonResponse
	{
		$userDTO = $this->dtoFactory->createUserDTO($request->all());
		$resendValidationCodeAction->execute($userDTO);
		return $this->responseSuccess([], 204);
	}

	/**
	 * @param LoginRequest $request
	 * @param LoginAction $loginAction
	 * @return JsonResponse
	 * @throws UnknownProperties|ApiException
	 */
	public function login(
		LoginRequest $request,
		LoginAction $loginAction
	): JsonResponse
	{
		$userDTO = $this->dtoFactory->createUserDTO($request->all());
		$data = $loginAction->execute($userDTO);
		return $this->responseSuccess($data);
	}

	/**
	 * @param LogoutAction $logoutAction
	 * @return JsonResponse
	 */
	public function logout(LogoutAction $logoutAction): JsonResponse
	{
		$logoutAction->execute();
		return $this->responseSuccess([], 200, MessageService::user('LOGGED_OUT'));
	}
}
