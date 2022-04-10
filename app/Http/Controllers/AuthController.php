<?php

namespace App\Http\Controllers;

use App\Actions\Auth\AccountValidateAction;
use App\Actions\Auth\CreateUserAction;
use App\Actions\Auth\ForgotPasswordAction;
use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\ResendValidationCodeAction;
use App\Actions\Auth\ResetPasswordAction;
use App\DTO\Factories\DTOFactory;
use App\Exceptions\ApiException;
use App\Http\Requests\Auth\AccountValidationRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\ResendValidateCodeRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Response\ApiResponse;
use App\Services\Messages\MessageService;
use Exception;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AuthController extends Controller
{
    use ApiResponse;

	public function __construct(
		public DTOFactory $dtoFactory,
	) {}

	/**
	 * @param RegisterUserRequest $request
	 * @param CreateUserAction $createUserAction
	 * @return JsonResponse
	 * @throws UnknownProperties
	 * @throws Exception
	 */
	public function register(RegisterUserRequest $request, CreateUserAction $createUserAction): JsonResponse
	{
		$userDTO = $this->dtoFactory->createUserDTO($request->all());
		$user = $createUserAction->execute($userDTO);
		return $this->responseSuccess($user->toArray(), 201);
	}

	/**
	 * @param AccountValidationRequest $request
	 * @param AccountValidateAction $accountValidateAction
	 * @return JsonResponse
	 * @throws UnknownProperties
	 * @throws ApiException
	 */
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
	 * @throws UnknownProperties|ApiException
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
	 * @throws ApiException
	 * @throws UnknownProperties
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

	public function logout(LogoutAction $logoutAction): JsonResponse
	{
		$logoutAction->execute();
		return $this->responseSuccess([], 200, MessageService::user('LOGGED_OUT'));
	}

	/**
	 * @param ForgotPasswordRequest $request
	 * @param ForgotPasswordAction $forgotPasswordAction
	 * @return JsonResponse
	 * @throws ApiException
	 * @throws UnknownProperties
	 */
	public function forgotPassword(
		ForgotPasswordRequest $request,
		ForgotPasswordAction $forgotPasswordAction
	): JsonResponse
	{
		$userDTO = $this->dtoFactory->createUserDTO($request->all());
		$forgotPasswordAction->execute($userDTO);
		return $this->responseSuccess([], 204);
	}

	/**
	 * @param ResetPasswordRequest $request
	 * @param ResetPasswordAction $resetPasswordAction
	 * @return JsonResponse
	 * @throws ApiException
	 * @throws UnknownProperties
	 */
	public function resetPassword(
		ResetPasswordRequest $request,
		ResetPasswordAction $resetPasswordAction
	): JsonResponse
	{
		$userDTO = $this->dtoFactory->createUserDTO($request->all());
		$resetPasswordAction->execute($userDTO);
		return $this->responseSuccess([], 204);
	}
}
