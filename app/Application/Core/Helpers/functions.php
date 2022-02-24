<?php

use JetBrains\PhpStorm\NoReturn;

function vdd($data): void {
	header('Content-type: application/json; charset=utf-8');
	header("Access-Control-Allow-Origin: *");
	$args = func_get_args();
	foreach ($args as $arg) {
		var_dump($arg);
	}
	die;
}
