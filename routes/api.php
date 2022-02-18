<?php

use Application\User\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [AuthController::class, 'findUser']);

Route::group(['prefix' => 'auth'], function () {
	Route::post('register', [AuthController::class, 'register']);
});

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
