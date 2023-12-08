<?php

namespace Sienekib\Mehael\Router\Src;

class Wildcards
{
    public static function foundWildcards(string $route) : bool
    {
        $pattern = "/^\/([a-zA-Z\_]+)\/\(([a-z]+):([a-z]+)\)/";

        return preg_match($pattern, $route);
    }

    public static function check(string $wild)
    {
        return preg_match('/^\(([a-z]+):([a-z]+)\)$/', $wild);
    }

}