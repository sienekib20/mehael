<?php

namespace Sienekib\Mehael\Support;

class Session
{
    public static function has(string $key)
    {
        return isset($_SESSION[$key]);
    }

    public static function setFlashMessage(string $key, string $message)
    {
        $_SESSION['__flash'][$key] = $message;
    }

    public static function hasFlash(string $key)
    {
        return isset($_SESSION['__flash'][$key]);
    }

    public static function getFlashMessage(string $key)
    {
        $flash_value = null;

        if (self::hasFlash($key)) {
            $flash_value = $_SESSION['__flash'][$key];
            self::removeFlash($key);
        }

        return $flash_value;
    }

    public static function remove(string $key)
    {
        unset($_SESSION[$key]);
    }

    public static function removeFlash(string $key)
    {
        unset($_SESSION['__flash'][$key]);
    }

    public static function auth()
    {
        return static::has('user_id');
    }

    public static function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;

        return new static;
    }

    public function regenerateId()
    {
        session_regenerate_id();
    }

    public static function get(string $key)
    {
        return static::has($key) ? $_SESSION[$key] : null;
    }

    public static function destroy()
    {
        foreach ($_SESSION as $key => $value) {
            if (self::has($key)) {
                self::remove($key);
            }
        }
    }

    public static function destroyFlash()
    {
        if (self::has('__flash')) {
            foreach ($_SESSION['__flash'] as $key => $value) {
                if (self::has($key)) {
                    self::remove($key);
                }
            }
        }

    }
}
