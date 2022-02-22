<?php

namespace Application\Core\Response;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

Trait ApiResponse
{
	/**
	 * @param Exception|Throwable $e
	 * @param int $statusCode
	 * @return JsonResponse
	 */
	public function responseExceptionError(Exception|Throwable $e, $statusCode = 500): JsonResponse
	{
		return response()->json([
			'message' => $e->getMessage(),
			'error' => [
				'code' => $e->getCode(),
				'line' => $e->getLine(),
				'File' => $e->getFile(),
			]
		], $statusCode);
	}

	public function responseSuccess(array $data = [], int $statusCode = 200, string $message = ''): JsonResponse
	{
		$responsedata = ['message' => $message];

		if (count($data)) {
			$responsedata['data'] = $data;
		}

		return response()->json($responsedata, $statusCode);
	}

	/**
	 * @param $message
	 * @param $statusCode
	 * @param array $errors
	 * @return JsonResponse
	 */
	public function responseError($message, $statusCode, array $errors = []): JsonResponse
	{
		$data = ['message' => $message];

		if (count($errors)) {
			$data['errors'] = $errors;
		}

		return response()->json($data, $statusCode);
	}

	/**
	 * @param string $token
	 * @return JsonResponse
	 */
	protected function responseWithToken(string $token): JsonResponse
	{
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth()->factory()->getTTL() * 1
		]);
	}
}
