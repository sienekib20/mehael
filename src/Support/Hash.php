<?php

namespace Sienekib\Mehael\Support;

class Hash
{
	public static function encrypt(string $value, string $algo = 'PASSWORD_BCRYPT') 
	{
		return password_hash($value, PASSWORD_BCRYPT);
	}

	public static function verify(string $hashed, string $value) 
	{
		return password_verify($value, $hashed);
	}

	public static function make(string $value)
	{
		return sha1($value);
	}
}