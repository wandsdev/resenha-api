<?php

namespace Application\Core;

use Illuminate\Foundation\Application as IlluminateApplication;

class Application extends IlluminateApplication
{
	/**
	 * Get the path to the application "app" directory.
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function path($path = ''): string
	{
		$appPath = $this->appPath ?: $this->basePath.DIRECTORY_SEPARATOR.'app/Application/Core';
		return $appPath.($path != '' ? DIRECTORY_SEPARATOR.$path : '');
	}
}
