<?php

namespace Application\Core\Http\Controllers;

use Illuminate\Http\Request;
use Support\User\Repositories\UserRepository;

class TestController extends Controller
{
    public function test(Request $request)
	{
		$data = UserRepository::test3(1);
//		dd($data);
		return response()->json(['data' => $data]);
	}
}
