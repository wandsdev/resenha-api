<?php

namespace Application\Core\Exceptions;

use Application\Core\Response\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
	use ApiResponse;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

	/**
	 * @param Request $request
	 * @param Throwable $e
	 * @return JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
	 * @throws Throwable
	 */
	public function render($request, Throwable $e): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
	{
		if ($e instanceof ApiException) {
			return $this->responseError($e->getMessage(), $e->getStatusCode());
		}
		return parent::render($request, $e);
	}
}
