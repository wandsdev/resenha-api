<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
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
