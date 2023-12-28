<?php
declare(strict_types=1);

namespace Sienekib\Mehael\Router\Src;

class Wildcards
{
    public static function foundWildcards(string $route) : int
    {
        $pattern = "/^\/([a-zA-Z\_]+)\/\(([a-z]+):([a-z]+)\)/";

        return preg_match($pattern, $route);
    }

    public static function check(string $wild)
    {
        return preg_match('/^\(([a-z]+):([a-z]+)\)$/', $wild);
    }

}