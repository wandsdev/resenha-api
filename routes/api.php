<?php

use Application\User\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
	Route::get('/user', [AuthController::class, 'findUser']);
});

Route::group(['prefix' => 'auth'], function () {
	Route::post('register', [AuthController::class, 'register']);
	Route::post('account-validation', [AuthController::class, 'accountValidation']);
	Route::post('validation-code', [AuthController::class, 'resendValidationCode']);
	Route::post('login', [AuthController::class, 'login']);
	Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
