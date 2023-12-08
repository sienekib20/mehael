<?php

namespace Sienekib\Mehael\Support;

class Session
{
    public static function has(string $key)
    {
        return isset($_SESSION[$key]);
    }

    public static function auth()
    {
        return static::has('user_id');
    }

    public static function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return static::has($key) ? $_SESSION[$key] : null;
    }
}
