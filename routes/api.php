<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user', function (Request $request) {
	return Redirect::to('https://teknisa.com');
//	return response()->json(['user' => 'user guest']);
});

Route::group(['middleware' => 'auth:api'], function () {
	Route::get('/user-auth', function (Request $request) {
		return $request->user();
	});
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
	Route::post('login', [AuthController::class, 'login']);
	Route::post('logout', [AuthController::class, 'logout']);
	Route::post('refresh', [AuthController::class, 'refresh']);
	Route::post('me', [AuthController::class, 'me']);

	Route::post('register', [AuthController::class, 'register']);
	Route::post('account_validation', [AuthController::class, 'accountValidation']);
	Route::post('resend_validation_code', [AuthController::class, 'resendValidationCode']);

	Route::post('forgot_password', [AuthController::class, 'forgotPassword']);
	Route::post('reset_password', [AuthController::class, 'resetPassword']);
});
