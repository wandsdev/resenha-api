<?php


namespace App\Traits;



use Exception;
use Illuminate\Http\JsonResponse;

Trait ApiResponse
{
    /**
     * @param Exception $e
     * @param int $statusCode
     * @return JsonResponse
     */
    public function responseExceptionError(Exception $e, $statusCode = 500): JsonResponse
    {
        return response()->json([
            'error' => [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'File' => $e->getFile(),
                'status_code' => $statusCode,
            ]
        ], $statusCode);
    }

	public function responseSuccess(array $data, string $message, int $statusCode): JsonResponse
	{
		return response()->json([
			'data' => $data,
			'message' => $message,
		], $statusCode);
	}

	/**
	 * @param $message
	 * @param $statusCode
	 * @return JsonResponse
	 */
    public function responseError($message, $statusCode, array $errors = []): JsonResponse
    {
        return response()->json([
        	'errors' => $errors,
			'message' => $message,
        ], $statusCode);
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
