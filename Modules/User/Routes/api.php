<?php

use Illuminate\Http\Request;

Route::get('/user-guest', function (Request $request) {
	return response()->json(['user' => 'João']);
});
