<?php

use Application\Core\Http\Controllers\TestController;
use Application\User\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Support\User\Models\User;

Route::get('/test', [TestController::class, 'test']);

Route::middleware('auth:sanctum')->group(function () {
	Route::get('/user', [AuthController::class, 'findUser']);
});

Route::group(['prefix' => 'auth'], function () {
	Route::post('register', [AuthController::class, 'register']);
	Route::post('account-validation', [AuthController::class, 'accountValidation']);
	Route::post('validation-code', [AuthController::class, 'resendValidationCode']);
	Route::post('login', [AuthController::class, 'login']);
	Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
	Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
	Route::post('reset-password', [AuthController::class, 'resetPassword']);
});
