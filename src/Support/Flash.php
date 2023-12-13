<?php

namespace Sienekib\Mehael\Support;

class Flash extends Session
{
	public function message(string $key)
	{
		return self::getFlashMessage($key);
	}
}