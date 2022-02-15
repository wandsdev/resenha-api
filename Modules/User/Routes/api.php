<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AuthController;

Route::group(['prefix' => 'auth'], function ($router) {
	Route::post('register', [AuthController::class, 'register']);
	Route::post('account_validation', [AuthController::class, 'accountValidation']);
	Route::post('login', [AuthController::class, 'login']);
//	Route::post('logout', [AuthController::class, 'logout']);
//	Route::post('refresh', [AuthController::class, 'refresh']);
//	Route::post('me', [AuthController::class, 'me']);
//
//	Route::post('account_validation', [AuthController::class, 'accountValidation']);
//	Route::post('resend_validation_code', [AuthController::class, 'resendValidationCode']);
//
//	Route::post('forgot_password', [AuthController::class, 'forgotPassword']);
//	Route::post('reset_password', [AuthController::class, 'resetPassword']);
});
